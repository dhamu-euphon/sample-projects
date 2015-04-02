<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Review extends MX_Controller
{

    /**
     * constructor
     *
     */
    function __construct()
    {
        parent::__construct();
        // setting current controller to the template class
        $this->template->set('controller', $this);
        $this->load->model('ride/ride_model', 'ride');
        $this->load->model('user/user_model', 'user');
        $this->load->model('review_model', 'review');
        $this->load->library('flexi_auth');
        $this->load->library('api/ajax', 'ajax');

        $this->lang->load("review", $this->config->item('active_language'));
    }

// -----------------------------------------------------------------------------------------

    /**
     * add function 'll send the message based on sender and ride
     *
     * @access public
     * @param  integer $sender_id
     * @param  integer $ride_id
     * @return boolean $result_flag
     */

    function add()
    {
        $this->load->model('user/user_model', 'user');

        $this->logged_in = $this->flexi_auth->is_logged_in();

        if (!$this->logged_in) {
            # if not logged show error message
            $dataArr = array();
            $pageArr = array('controller' => 'review', 'view' => 'error');
            $this->ajax->render($pageArr, $dataArr);
        }
        $receiver_id = intval($this->input->post('receiver_id'));
        $score = intval($this->input->post('score'));
        $ride_id = intval($this->input->post('hdn_ride_id'));

        if (trim($this->input->post('stage')) == 'NEW') {
            $dataArr = array(
                'receiver_id' => $receiver_id
            );
            $pageArr = array('controller' => 'review', 'view' => 'new_review');
            $this->ajax->render($pageArr, $dataArr);
        }

        # Get posted data
        $user_id = $this->flexi_auth->get_user_id();

        $review_text = trim($this->input->post('text'));

        if ($receiver_id == $user_id) {
            $dataArr = array();
            $pageArr = array('controller' => 'review', 'view' => 'error');
            $this->ajax->render($pageArr, $dataArr);
        }

        if (!$review_text) {
            $dataArr = array();
            $pageArr = array('controller' => 'review', 'view' => 'error');
            $this->ajax->render($pageArr, $dataArr);
        }

        $review_status = $this->user->getReviewStatus($ride_id, $user_id, $receiver_id);
        if (!$review_status) {
            $dataArr = array();
            $pageArr = array('controller' => 'review', 'view' => 'error');
            $this->ajax->render($pageArr, $dataArr);
        }

        $mesageDtlArr = array(
            'receiver_id' => $receiver_id,
            'sender_id' => $user_id,
            'review_text' => $review_text,
            'rating' => $score
        );
        $review_id = $this->review->addNewReview($mesageDtlArr);
        if (!empty($review_id) && is_numeric($review_id)) {
            $sumCountArr = $this->review->getSumAndCountOfRating($receiver_id);
            $average_rating = 0;
            if (!empty($sumCountArr)) {
                $unrouded_val = ($sumCountArr['Sum']) / (($sumCountArr['Count'] / 0.5) * 0.5);
                $average_rating = round($unrouded_val * 2) / 2;
            }

            $ratingArr = array('upro_rating' => $average_rating);
            $update_rating = $this->review->updateUserCommonRating($receiver_id, $ratingArr);

            $reviewStatusArr = array(
                'ride_id' => $ride_id,
                'sender_id' => $user_id,
                'receiver_id' => $receiver_id,
                'status' => 1
            );
            $update_review_status = $this->user->updateReviewStatus($reviewStatusArr);
        }
        $dataArr = array(
            'review_id' => $review_id,
            'receiver_id' => $receiver_id
        );
        $pageArr = array('controller' => 'review', 'view' => 'new_review');
        $this->ajax->render($pageArr, $dataArr);
    }

// -----------------------------------------------------------------------------------------

    /**
     * getReview 'll the reviews by receiver
     *
     * @access public
     * @param  integer $ride_id
     * @return bool    $userDetailsArr
     */

    function getReview()
    {
        $this->logged_in = $this->flexi_auth->is_logged_in();
        if (!$this->logged_in) {
            # if not logged show error message
            $dataArr = array();
            $pageArr = array('controller' => 'review', 'view' => 'error');
            $this->ajax->render($pageArr, $dataArr);
        }

        $receiver_id = intval($this->input->post('receiver_id'));
        if (!$receiver_id) {
            $dataArr = array();
            $pageArr = array('controller' => 'review', 'view' => 'error');
            $this->ajax->render($pageArr, $dataArr);
        }

        $login_id = $this->flexi_auth->get_user_id();
        $reviewDtlArr = $this->review->getReviewsByReceiver($receiver_id);
        $receiverArr = array();
        $userDtlArr = array();
        if (count($reviewDtlArr)) {
            foreach ($reviewDtlArr as $key => $value) {
                # code...
                array_push($receiverArr, $value['sender_id']);
            }
            array_push($receiverArr, $receiver_id);
            $receiverArr = array_unique($receiverArr);
            $receiverArr = array_filter($receiverArr);

            if (count($receiverArr)) {

                foreach ($receiverArr as $key_2 => $value_2) {
                    # code...
                    $tempUserArr = array();
                    array_push($tempUserArr, $this->user->getUserDetailsById($value_2));
                    $userDtlArr[$value_2] = isset($tempUserArr[0][0]) ? $tempUserArr[0][0] : '';
                }
            }
            $userDtlArr = array_filter($userDtlArr);

            $pageArr = array(
                'controller' => 'review',
                'view' => 'show_review'
            );
            $dataArr = array(
                'receiver_id' => $receiver_id,
                'review_count' => true,
                'userDtlArr' => $userDtlArr,
                'reviewDtlArr' => $reviewDtlArr
            );
            $this->ajax->render($pageArr, $dataArr);

        } else {
            $tempUserArr = $this->user->getUserDetailsById($receiver_id);
            $userDtlArr[$receiver_id] = isset($tempUserArr[0]) ? $tempUserArr[0] : '';
            #print_r($userDtlArr);
            $pageArr = array(
                'controller' => 'review',
                'view' => 'show_review'
            );
            $dataArr = array(
                'receiver_id' => $receiver_id,
                'review_count' => false,
                'userDtlArr' => $userDtlArr
            );
            $this->ajax->render($pageArr, $dataArr);
        }


    }

// -----------------------------------------------------------------------------------------

    /**
     * switchLanguage 'll the reviews by receiver
     *
     * @access public
     * @param  integer $language_id
     */

    function switchLanguage()
    {
        $language_id = $this->input->post('language_id');
        if (intval($language_id)) {
            switch ($language_id) {
                case 2:
                    # English
                    $config['language'] = 'english';
                    $config['active_language'] = 'english';
                    break;

                case 1:
                    # Indonesian
                    $config['language'] = 'indonesian';
                    $config['active_language'] = 'indonesian';
                    break;

                default:
                    # default
                    $config['language'] = 'indonesian';
                    $config['active_language'] = 'indonesian';
                    break;
            }
            $this->session->set_userdata('active-language', $config['active_language']);
            $result = array('status' => 'ok', 'language' => $language_id);
            exit(json_encode($result));
        } else {
            return null;
        }
    }

}
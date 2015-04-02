<?php
class Review_Model extends CI_Model
{

    public $table_name = 'tbl_review';
    public $profile_table = 'user_profiles';
    public $table_name_status = 'tbl_review_status';

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('Subquery', 'subquery');

    }

// -----------------------------------------------------------------------------------------		
    /**
     * addNewReview function 'll insert a review
     *
     * @access public
     * @params array   $dataArr
     * @return integer $review_id
     */

    function addNewReview($dataArr)
    {
        $dataArr['added_date'] = date('Y-m-d h:i:s');
        $this->db->insert($this->table_name, $dataArr);
        return $this->db->insert_id();
    }

// -----------------------------------------------------------------------------------------
    /**
     * getReviewsByReceiver function 'll fetch the reviews by receiver_id
     *
     * @access public
     * @param integer $receiver_id
     * @return array  $reviewArr
     */

    function getReviewsByReceiver($receiver_id)
    {
        $this->db->select('*');
        $this->db->where('receiver_id', $receiver_id);
        $this->db->where('status', '1');
        $this->db->order_by('last_updated', 'DESC');
        $query = $this->db->get($this->table_name);
        return $query->result_array();
    }

// -----------------------------------------------------------------------------------------

    /**
     * getSumAndCountOfRating function 'll fetch the average rating by receiver_id
     *
     * @access public
     * @param integer $receiver_id
     * @return array  $resultArr
     */

    function getSumAndCountOfRating($receiver_id)
    {

        $query_atring = "SELECT (SUM(rating)) AS Sum, (COUNT(rating)) AS Count FROM $this->table_name WHERE receiver_id=$receiver_id";

        $query = $this->db->query($query_atring);

        return $query->row_array();

    }

// -----------------------------------------------------------------------------------------

    /**
     * updateUserCommonRating function 'll update the average rating by receiver_id
     *
     * @access public
     * @param integer $receiver_id
     * @return boolean true
     */

    function updateUserCommonRating($receiver_id, $ratingArr)
    {
        $this->db->where('upro_uacc_fk', $receiver_id);
        $query = $this->db->update($this->profile_table, $ratingArr);
        return true;
    }

// -----------------------------------------------------------------------------------------
    /**
     * insertReviewStatus function 'll insert a review status as batch
     *
     * @access public
     * @params array   $dataArr
     * @return boolean $status
     */

    function insertReviewStatus($dataArr)
    {
        return $this->db->insert_batch($this->table_name_status, $dataArr);
    }
// -----------------------------------------------------------------------------------------

}

?>
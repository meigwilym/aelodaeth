<?php if(!defined('BASEPATH')) exit('No direct script access allowed.');

/**
 * Subscriptions model
 */
class Subs_model extends MY_Model {

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Save a subscription
     * @param array member data
     * @return bool
     */
    public function save($sub)
    {
        $sub['created_on'] = date('Y-m-d h:i:s');
        return $this->insert($sub);
    }

    /**
     * Get by Subs id
     * @param type $id
     */
    public function get($id)
    {
        $sql = "SELECT member_id FROM subs WHERE id = '".mysql_real_escape_string($id)."';";
        $row = $this->db->query($sql)->row();

        return $this->aelod->get($row->member_id);
    }

    /**
     * Record a payment's details
     * @param array key=>val data
     * @return bool
     */
    public function receive_data($conf)
    {
        $this->db->where('id', $conf['state']);
        unset($conf['state']);

	// set confirm to 1
        $conf['confirmed'] = '1';
        $conf['status'] = 'pending'; // update from none

        return $this->db->update('subs', $conf);
    }

    /**
     * Return all payments made within a certain month
     *
     * @param str $month
     * $param str $year
     */
    public function report($month = null, $year = null)
    {
        $sql = "SELECT m.id, m.first_name, m.last_name,
            s.created_on, s.method, s.amount, s.notes, s.status,
            mt.membership_type
            FROM subs AS s
            JOIN members AS m
                ON s.member_id = m.id
            JOIN membership_types AS mt
                ON s.membership_type_id = mt.id
            WHERE (confirmed = '1' OR confirmed = 1)
            AND s.created_on BETWEEN '$year-$month-01 00:00:00' AND DATE_ADD('$year-$month-01 00:00:00', INTERVAL 1 MONTH)
            AND s.status = 'paid'
            GROUP BY m.id
            ORDER BY s.created_on DESC
            ;";

        return $this->db->query($sql)->result();
    }

	/**
	 * Set a sub payment as paid
	 *
	 * @param string gocardless' resource id
	 */
	public function paid($resource_id)
	{
            $sql = "UPDATE subs SET status = 'paid' WHERE resource_id = '".  mysql_real_escape_string($resource_id)."';";
            return $this->CI->db->query($sql);
	}

	/**
	 * Set a sub payment as failed
	 *
	 * @param string gocardless' resource id
	 */
	public function failed($resource_id)
	{
            $sql = "UPDATE subs SET status = 'failed' WHERE resource_id = '".  mysql_real_escape_string($resource_id)."';";
            return $this->CI->db->query($sql);
	}

}
// EOC

// end of file ./application/models/subs_mod.php
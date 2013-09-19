<?php

/**
 * Aelod
 * 
 * CRUD class for membership
 *
 * @author Mei Gwilym <mei.gwilym@gmail.com>
 */
class Aelod {
    
    protected $CI;
    
    public function __construct()
    {
        $this->CI =& get_instance();
        
        $this->CI->load->model('Member_model', 'membs');
        $this->CI->load->model('Subs_model', 'subs');
        $this->CI->load->model('Membership_type_model', 'm_types');
        $this->CI->load->model('Group_model', 'groups');
    }
    
    /**
     * Return a single member 
     * with payment history
     * 
     * @param int $id
     * @return object
     */
    public function get($id)
    {
        return $this->CI->membs->get($id);
    }
    
    /**
     * Returns member data by email
     * with payment history
     * 
     * @param string $email
     * @return object
     */
    public function getByEmail($email)
    {
        $memb = $this->CI->membs->get_by('email', $email);
        if($memb) return $this->CI->membs->get($memb->id);
        
        return false;
    }
    
    /**
     * Saves a member
     * insert/update
     * 
     * @param array $data
     * @return type
     */
    public function save_member($data)
    {
        if(isset($data['membership_type_id']))
            unset($data['membership_type_id']);
        
        // not meant as a password, just a one off key to identify them
        $data['secret_key'] = md5($data['email'].date('Y-m-d H:i:s'));
        
        return $this->CI->membs->save($data);
    }
    
    /**
     * Saves a new subscription
     * 
     * @param array $data keys = member_id, membership_type_id, method
     * @return int insert id
     */
    public function save_sub($data)
    {
        if(!is_array($data))
        {
            $args = func_get_args();
            $data = array('member_id' => $args[0], 'membership_type_id'=>$args[1],'method'=>$args[2]);
        }
        
        $mt = $this->type($data['membership_type_id']);
        
        $data['amount'] = $mt->amount;
        
        // get the new expiry date
        $ends_on = $this->new_expiry($data['member_id'], $mt);

        $data['ends_on'] = $ends_on->format('Y-m-d H:i:s');
        
        return $this->CI->subs->save($data);
    }
    
    /**
     * All current members
     * 
     * @return object
     */
    public function all_current()
    {
        return $this->CI->membs->get_all_current();
    }
    
    /**
     * All expired members
     * @return object
     */
    public function all_expired()
    {
        return $this->CI->membs->get_all_expired();
    }
    
    /**
     * A member's latest subscription 
     * 
     * @param int $id
     * @return object
     */
    public function latest_sub($id)
    {
        return $this->CI->subs->order_by('ends_on', 'DESC')
                    ->limit(1)
                    ->get_by('member_id', $id);
    }
    
    /**
     * calculates a member's next expiry date
     * 
     * @param int $id
     * @return object Datetime PHP date
     */
    public function new_expiry($id, $mt)
    {
        // get latest subscription
        $subs = $this->CI->subs->order_by('ends_on', 'DESC')->limit(1)->get_by('member_id', $id);
        
        // join till end of current season if not a member
        $ends_on = $this->CI->config->item('tymor_gorffen'); // return PHP Datetime object

        // if a current member, then start from the end of the latest membership period
        if(isset($subs->ends_on) && (strtotime($subs->ends_on) >= $ends_on->getTimestamp()))
        {
            $ends_on = new DateTime($subs->ends_on);
            $ends_on->add(new DateInterval('P'.$mt->time_period.'Y'));
        } // else, it expires at the end of this season
        
        return $ends_on;
    }
    
    /**
     * Get a specific membership type
     * 
     * @param type $id
     */
    public function type($id)
    {
        return $this->CI->m_types->get($id);
    }

    /**
     * List of membership types
     * 
     * @return object 
     */
    public function types()
    {
        return $this->CI->m_types->get_many_by('status', 1);
    }
    
    /**
     * Receive the GoCardless request
     * 
     * @param array $data gocardless get array values
     * @return type
     */
    public function receive($data)
    {
        return $this->CI->subs->receive_data($data);
    }
    
	
    /**
     * Delete a sub
     * e.g. if the gocardless confirmation did not work
     * 
     */
    public function delete_sub($id)
    {
		return false;
        // return $this->CI->subs->delete($id);
    }
    
    /**
     * Get the groups that a member is part of
     * @param int $id
     */
    public function get_member_groups($id)
    {
        return $this->CI->membs->get_member_groups($id);
    }
    
    /**
     * Confirm that the money is in the bank
     * 
     * @param array $data received from GoCardless
     */
    public function payment_confirm($bills)
    {
        foreach($bills as $b)
        {
            $this->CI->subs->paid($b['id']);
            //$this->log('PAID', $b['id']);
            
            // @todo send confirmation email
        }
    }
    
    /**
     * Payment has failed. 
     * @param type $data
     */
    public function payment_failed($bills)
    {
        foreach($bills as $b)
        {
            $this->CI->subs->failed($b['id']);
            //$this->log('FAIL', $b['id']);
            
            // @todo send email
        }
    }
    
    /**
     * returns a query of reports
     */
    public function report($month, $year)
    {
        return $this->CI->subs->report($month, $year);
    }
	
	/**
				Views
			
				All methods are suffixed with show... 
				return a string and do not echo out the view
	**/
	
	/**
	 * Renewal form
	 * 
	 */
	public function showRenew($data = null)
	{
		return $this->CI->load->view('aelodaeth/adnewyddu', $data, true);
	}
	
	public function showAll($data = null)
	{
		return $this->CI->load->view('aelodaeth/all', $data, true);
	)
	
	public function showArray($data = null)
	{
		return $this->CI->load->view('aelodaeth/array', $data, true);
	)
	
	/**
	 * Reminder
	 * 
	 */
	public function showAtgoffa($data = null)
	{
		return $this->CI->load->view('aelodaeth/', $data, true);
	)
	
	
	public function showEdit($data = null)
	{
		return $this->CI->load->view('aelodaeth/edit', $data, true);
	)
	
	/**
	 * Membership home
	   @tod needed? perhaps not in a library
	 * 
	 */
	public function showIndex($data = null)
	{
		return $this->CI->load->view('aelodaeth/index', $data, true);
	)
	
	public function showReports($data = null)
	{
		return $this->CI->load->view('aelodaeth/reports', $data, true);
	)
	
    /**
     * send email to confirm that request has been made
     * @todo move into other class
     * @param int subscription id
     */
    public function emailConfirmRequest($id)
    {
        $member = $this->CI->subs->get($id);
        
        $this->CI->load->library('email');
        
        $this->CI->email->from('info@clwbrgbicaernarfon', 'Clwb Rygbi Caernarfon');
        $this->CI->email->to($member->email);
        $this->CI->email->cc('info@clwbrgbicaernarfon');

        $this->CI->email->subject('Cais am Aelodaeth / Membership Request');
        
        $msg = "{$member->first_name} {$member->last_name},

Diolch am wneud cais am aelodaeth gyda Clwb Rygbi Caernarfon

Byddwn yn cadarnhau eich aelodaeth mewn ychydig ddyddiau, pan bydd yr arian wedi'i drosglwyddo'n llwyddianus. 

Thanks for requesting memebrship to Clwb Rygbi Caernarfon.

We'll confirm membership within a few days, after funds have been successfully transferred.

Cofion / Regards,

Clwb Rygbi Caernarfon";
        $this->CI->email->message($msg);	

        $this->CI->email->send();
        
        if(ENVIRONMENT == 'development') $this->CI->email->print_debugger();
    }
    
    /**
     * When GoCardless cofirms payment
     * @todo move into other class
     * @param mixed $data
     */
    public function emailConfirmPayment($id)
    {
        $member = $this->CI->subs->get($id);
        
        $this->CI->load->library('email');
        
        $this->CI->email->from('info@clwbrgbicaernarfon', 'Clwb Rygbi Caernarfon');
        $this->CI->email->to($member->email);
        $this->CI->email->cc('alion@alion.plus.com', 'info@clwbrgbicaernarfon');

        $this->CI->email->subject('Aelodaeth / Membership');
        
        $expiry = date('d/m/Y', strtotime($member->ends_on));
        
        $msg = "{$member->first_name} {$member->last_name},

Dim ond nodyn bach i gadarnhau bod yr arian aelodaeth wedi'i drosglwyddo'n llwyddianus i'n cyfrif banc.

Eich rhif aelodaeth yw $member->id, a bydd yr yn para hyd at $expiry;

This is just a quick message to confirm that funds have been sucessfully tranferred to our bank account. 

Your membership number is $member->id, and will be valid until $expiry.

Cofion / Regards,

Clwb Rygbi Caernarfon";
        $this->CI->email->message($msg);	

        $this->CI->email->send();
        
        if(ENVIRONMENT == 'development') $this->CI->email->print_debugger();
    }
    
    /**
     * Logs the payment

     * @param type $log_msg
     * @param type $m
     */
    public function log($log_msg, $rid)
    {
        $log_file_name = 'payments-'.date('Y-m-d');
        write_file('./application/logs/aelodaeth/'.$log_file_name, date('Y-m-d H:i:s').' - '.$log_msg.' for resource_id '.$rid."\n", 'a');
    }
} // EOC

<?php

class Member_model extends MY_Model {
    
    /* to be removed from any queries */
    public $protected_attributes = array('id');
    
    /** 
     * Relationships 
     * @var type array
     */
    public $has_many = array('subs');
    
    /**
     * Observers
     * @var type 
     */
    public $before_create = array( 'created_on');
    
    /**
     * Gets a single member and it's subs 
     * 
     * @param int $id Member ID
     */
    public function get($id)
    {
        $sql = "SELECT m.id, m.first_name, m.last_name, m.email, m.billing_address1, m.billing_address2, m.billing_town, m.billing_postcode, m.rhif_ffon, m.secret_key, m.created_on AS m_created_on, 
                    s.id AS subs_id, s.amount, s.created_on, s.ends_on, s.method, s.status, s.notes, 
                    mt.membership_type
            FROM members AS m 
            LEFT OUTER JOIN subs AS s
                ON m.id = s.member_id 
            LEFT OUTER JOIN membership_types AS mt
                ON s.membership_type_id = mt.id
            WHERE m.id = ".mysql_real_escape_string($id)."                
            ORDER BY s.created_on DESC, s.ends_on DESC, m.id DESC
            ;";
        
        $res = $this->db->query($sql)->result();
        
        $memb = new stdClass();
        
        // Hydrate the array
        // provide the subscription info as a separate array
        foreach($res as $rec)
        {
            if(!isset($memb->id))
            {
                $memb = $rec;
                // is current member?
                $memb->is_current = (new DateTime($rec->ends_on) >= $this->config->item('tymor_gorffen')) ? true : false;
                $memb->subs = array();
            }
            if(!is_null($rec->subs_id)) $memb->subs[] = $rec;
        }
        
        return $memb;
    }
    
    /**
     * Returns all members
     * @return type
     */
    public function get_all_current()
    {
        $memb = array();
        
        $sql = "SELECT m.id, m.first_name, m.last_name, m.billing_address1, m.billing_address2, m.billing_town, m.billing_postcode, m.rhif_ffon, m.created_on AS m_created_on,
		s.id AS subs_id, s.amount, s.created_on, MAX(s.ends_on) AS ends_on, s.status, s.notes 
            FROM members AS m 
            LEFT OUTER JOIN subs AS s
                ON m.id = s.member_id 
            WHERE s.ends_on >= '".mysql_real_escape_string($this->config->item('tymor_gorffen')->format('Y-m-d H:i:s'))."'
            AND s.status IN ('paid', 'pending') 
            GROUP BY m.id
            ORDER BY m.created_on DESC;";
        
        return $this->db->query($sql)->result();
    }
    
    /**
     * All expired members
     */
    public function get_all_expired()
    {
        $memb = array();
        
        $sql = "SELECT m.id, m.first_name, m.last_name, m.email, m.billing_address1, m.billing_address2, m.billing_town, m.billing_postcode, m.rhif_ffon, m.secret_key, m.created_on AS m_created_on,
			s.id AS subs_id, s.amount, s.created_on, s.ends_on, s.status, s.notes 
            FROM members AS m 
            LEFT OUTER JOIN subs AS s
                ON m.id = s.member_id
            WHERE (NOT EXISTS (SELECT NULL 
                                FROM subs 
                                WHERE member_id = m.id
                                AND ends_on >= '".$this->config->item('tymor_gorffen')->format('Y-m-d H:i:s')."'
                               ) 
                               OR status IN ('none', 'failed') )
            GROUP BY m.id
            ORDER BY s.ends_on DESC
            ;";
        
        return $this->db->query($sql)->result();
    }
    
    /**
     * Save the member 
     * insert or update
     * 
     * @param array $data
     * @return int
     */
    public function save($data)
    {
        if(isset($data['id']))
        {
            $id = $data['id'];
            $this->db->where('id', $id);
            unset($data['id']);
            
            $data['edited_on'] = date('Y-m-d h:i:s');
            $this->db->update('members', $data);
            return $id;
        }
        
        $data['created_on'] = date('Y-m-d h:i:s');
        $this->db->insert('members', $data);        
        return $this->db->insert_id();
    }
    
    /**
     * Get all the groups of which a member is part of
     * 
     * @param int $id member id
     * @return obj
     */
    public function get_member_groups($id)
    {
        $sql = "SELECT g.id, g.groupname_cy, g.groupname_en, gm.notes
                FROM groups AS g
                JOIN group_members AS gm
                  ON g.id = gm.group_id
                WHERE gm.member_id = '".mysql_real_escape_string($id)."'
            ;";
        
        return $this->db->query($sql)->result();
    }
}

/* ./application/models/Member_model.php */
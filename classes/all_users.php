<?php

/**
 * BadgeCerts table for displaying list of users with certificate.
 *
 * @package    report_reportbadges
 * @copyright  2014 Andraž Prinčič <atletek@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die;

class all_users extends table_sql {

    /**
     * Constructor
     * @param int $uniqueid all tables have to have a unique id, this is used
     *      as a key when storing table properties like sort order in the session.
     */
    function __construct($uniqueid) {
        parent::__construct($uniqueid);       

        $this->collapsible(false);
        $this->sortable(true);
        $this->pageable(true);
    }

    /**
     * This function is called for each data row to allow processing of the
     * username value.
     *
     * @param object $values Contains object with all the values of record.
     * @return $string Return username with link to profile or username only
     *     when downloading.
     */
    function col_timecreated($values) {
        if ($values->timecreated > 0) {
            return userdate($values->timecreated);
        } 
        
        return '';
    }

    function col_fullname($values) {
        if (empty($values->otheroptions)) {
            return html_writer::link(new moodle_url('/user/profile.php', array('id' => $values->id)), "{$values->firstname} {$values->lastname}", array());
        } else {
            return html_writer::link(new moodle_url('/user/profile.php', array('id' => $values->id)), "{$values->firstname} {$values->lastname}", array()) . "({$values->otheroptions})";
        }
    }
    
    function col_numrec($values) {        
        if ($values->numrec == 0) {
            return '';
        } else {
            return $values->numrec;
        }
    }
    
    function col_info($values) {
        
        $completed = '&nbsp;';
        
        if ($values->completed) {
            $completed = '&#x2713;';
        } 
        
        return $completed;
    }    

    function col_selected($values) {
        if (!$this->is_downloading()) {
            return '<input type="checkbox" class="usercheckbox" name="user[][' . $values->userid . ']" value="' . $values->userid . '" />';
        } else {
            return '';
        }
    }

    /**
     * This function is called for each data row to allow processing of
     * columns which do not have a *_cols function.
     * @return string return processed value. Return NULL if no change has
     *     been made.
     */
    function other_cols($colname, $value) {
        
    }

}
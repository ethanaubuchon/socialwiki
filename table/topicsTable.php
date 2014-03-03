<?php
global $CFG;

require_once($CFG->dirroot . '/mod/socialwiki/locallib.php');
require_once($CFG->dirroot . '/mod/socialwiki/sortableTable/sortableTable.php');
require_once($CFG->dirroot . '/mod/socialwiki/table/table.php');


class TopicsTable extends socialwiki_table {
	private $tlist;
	private $cmid;
	private $courseid;
//	private $swid;

	
	public function __construct( $uid, $swid, $list, $headers, $courseid, $cmid) {
		parent::__construct($uid, $swid, $headers);
		$this->tlist = $list;
		$this->courseid= $courseid;
		$this->cmid= $cmid;
	}

	

	public static function make_all_topics_table($uid, $swid,  $courseid, $cmid) {
		$topics = socialwiki_get_topics($swid);

		if (empty($topics)){
			return null;
		}
		$headers = TopicsTable::get_headers();

		return new TopicsTable($uid, $swid, $topics, $headers,  $courseid, $cmid);

	}

	public static function get_headers(){ //TODO: make configurable
		$col_names = array(
			"Title",
		// "Last Update",
			"Number of Versions",
			"Number of Views",
			"Number of Likes",
			);
		return $col_names;
		}

	/** gets the topics that are new since last login (no pages with that title existed previously)*/
	public static function make_new_topics_table($swid, $courseid, $cmid) {
		//$topics = get_topics($this->swid);
		
		return null;//$this->make_table($topics, "all_topic_table");
	}

	protected function get_table_data() {
		Global $COURSE, $PAGE;
		$topics = $this->tlist;

		$table = array();

		foreach ($topics as $title => $data) {
			
			
			$titlelink = '<a href="search.php?searchstring='.$title.'&courseid='.$this->courseid.'&cmid='.$this->cmid.'&option=2">'.$title.'</a>';

			$row = array(
				"Title" => $titlelink,
				"Number of Versions" => $data["Versions"],
				"Number of Views" => $data["Views"],
				"Number of Likes" => $data["Likes"],
			);

            $table[] = $row; //add row to table
		}

		return $table;
	}


}
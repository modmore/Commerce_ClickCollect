<?php

namespace modmore\Commerce_ClickCollect\Admin\Schedule;

use modmore\Commerce\Admin\Page;
use modmore\Commerce\Admin\Sections\SimpleSection;

class Duplicate extends Page {
    public $key = 'clickcollect/schedule/duplicate';
    public $title = 'commerce_clickcollect.duplicate_schedule';
    public static $permissions = ['commerce'];

    public function setUp()
    {
        $objectId = (int)$this->getOption('id', 0);
        $duplicate = $this->adapter->getObject('clcoSchedule', ['id' => $objectId]);

        if ($duplicate instanceof \clcoSchedule) {
            $new = $duplicate->duplicate();

            if (!$new) {
                return $this->returnError('Could not create duplicate of schedule.');
            }
            $section = new SimpleSection($this->commerce, [
                'title' => $this->title
            ]);

            $section->addWidget((new Form($this->commerce, ['isUpdate' => true, 'id' => $new->get('id')]))->setUp());
            $this->addSection($section);
            return $this;
        }
        return $this->returnError($this->adapter->lexicon('commerce.item_not_found'));
    }
}
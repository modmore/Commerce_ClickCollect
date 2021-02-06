<?php

namespace modmore\Commerce_TimeSlots\Admin\Planning;

use modmore\Commerce\Admin\Sections\SimpleSection;
use modmore\Commerce\Admin\Page;
use modmore\Commerce\Admin\Widgets\TextWidget;

class Update extends Page {
    public $key = 'timeslots/planning/edit';
    public $title = 'commerce_timeslots.edit_planning';
    public static $permissions = ['commerce'];

    public function setUp()
    {
        $objectId = (int)$this->getOption('id', 0);
        $exists = $this->adapter->getCount(\ctsDate::class, ['id' => $objectId]);

        if ($exists) {
            $section = new SimpleSection($this->commerce, [
                'title' => $this->title
            ]);
            $section->addWidget((new Form($this->commerce, ['isUpdate' => true, 'id' => $objectId]))->setUp());
            $this->addSection($section);
            return $this;
        }

        return $this->returnError($this->adapter->lexicon('commerce.item_not_found'));
    }
}
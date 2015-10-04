<?php

class Controller_Thought_List extends Controller_Base {
    const TPL_PATH = 'thoughts/list';
    const NO_THOUGHTS_TPL_PATH = 'thoughts/no_thoughts';

    private $charge_id;

    public function __construct() {
        parent::__construct();
        $this->charge_id = $this->request->getGet('charge_id');
    }

    protected function handleRequestInternal() {
        if (isset($this->charge_id) && $this->charge_id !== 0) {
            $this->findChargeAndAssignDescription();
            $thoughts = Finder_Thought::getFinder()->findRecentThoughtsForChargeId($this->charge_id);
        } else {
            $thoughts = Finder_Thought::getFinder()->findRecentThoughts();
        }

        if (empty($thoughts)) {
            $this->render(self::NO_THOUGHTS_TPL_PATH);
            return;
        }

        $this->assign('thoughts', $thoughts);

        $this->render(self::TPL_PATH);
    }

    protected function getPageTitle() {
        return "Thoughts for the thought god!";
    }

    private function findChargeAndAssignDescription() {
        $charge = Finder_Charge::getFinder()->findRecord($this->charge_id);
        $charge_description = isset($charge)? $charge->description : null;
        $this->assign('charge_description', $charge_description);
    }
}
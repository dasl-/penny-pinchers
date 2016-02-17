<?

class Api_Thoughts_New extends Api_Endpoint {

    /**
     * @return array An associative array that will be turned into json as the response.
     */
    protected function handleRequestInternal() {
        $user_id = $this->request->getPost('user_id');
        $title = $this->request->getPost('title');
        $text = $this->request->getPost('text');

        $thought = new Model_Thought();
        $thought->user_id = $user_id;
        $thought->charge_id = 0;
        $thought->deleted = false;
        $thought->upvotes = 1;
        $thought->title = $title;
        $thought->text = $text;
        $thought->store();

        return [
            'thought_title' => $thought->title,
        ];
    }
}

<?php
class Controller_Cart extends Controller
{
    public function __construct()
    {
        Controller::__construct();
        $this->model = new Model_Cart();
    }

    public function action_index()
    {
        $data = $this->model->get_all();
        $this->view->generate("cart_all.php", "template_view.php", $data);
        // if ($data == false) {
        //     echo "404";
        // } else {
        // }
    }

    public function action_cart($id)
    {
        $data = $this->model->add_to_cart($id);
        if ($data != 0) {
            header("Location: /MuratbayevA/february_22/onlinestore/public_html/item/id/$id");
        }
    }
}
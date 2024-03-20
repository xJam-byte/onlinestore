<?php
class Model_Cart extends Model
{
    public function get_data()
    {
        return [
            "title" => "Cart"
        ];
    }

    public function get_all()
    {

        $qr = "SELECT * FROM cart JOIN items ON cart.id_item = items.id_item AND cart.id_customer = :user";
        $pr = ["user" => 64];
        return $this->db->getAll($qr, $pr);
        // if ($this->db->getCount($qr, $pr) == 0) {
        //     return false;
        // } else {
        //     return $this->db->getAll($qr, $pr);
        // }
    }

    public function add_to_cart($item)
    {
        $qr = "SELECT * FROM cart WHERE id_customer = :user AND id_item = :item";
        $pr = ["user" => 64, "item" => $item];

        if ($this->db->getCount($qr, $pr) == 0) {
            $qr = "INSERT INTO cart (id_customer, id_item) VALUES (:user, :item)";
            return $this->db->insert($qr, $pr);
        } else {
            $qr = "UPDATE cart SET quantityAdded = quantityAdded + 1 WHERE id_customer = :user AND id_item = :item";
            return $this->db->query($qr, $pr);
        }
    }

    public function get_item($id)
    {
        $qr = "SELECT * FROM items WHERE id_item = :id";
        $pr = ["id" => $id];
        if ($this->db->getCount($qr, $pr) == 0) {
            return false;
        } else {
            return $this->db->getRow($qr, $pr);
        }
    }
}
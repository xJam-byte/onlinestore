<?php
class Model_Purchase extends Model
{
    public function get_data()
    {
        return [
            "title" => "Purchase"
        ];
    }

    public function get_all()
    {

        $qr = "SELECT * FROM cart JOIN items ON cart.id_item = items.id_item AND cart.id_customer = :user";
        $pr = ["user" => 64];
        if ($this->db->getCount($qr, $pr) == 0) {
            return false;
        } else {
            return $this->db->getAll($qr, $pr);
        }
    }

    public function purchase($address, $amount, $data)
    {
        $qr = "INSERT INTO `orders`(`status_id`, `manager_comment`, `delivery_address`, `total_amount`, `customer_code`) VALUES (1, 'no comments', :addr, :amount, :user) ";
        $pr = ["user" => 64, "addr" => $address, "amount" => $amount];
        $orderId = $this->db->insert($qr, $pr);

        $qr = "SELECT * FROM orders WHERE order_id = :id";
        $pr = ["id" => $orderId];
        if ($this->db->getCount($qr, $pr) == 0) {
            return false;
        } else {
            foreach ($data as $item) {
                $qr = "INSERT INTO `order_details`(`order_id`, `product_code`, `quantity`, `price`) VALUES ($orderId, :item_id, :q, :price)";
                $pr = ["item_id" => $item["id_item"], "q" => $item["quantityAdded"], "price" => $item["item_price"]];
                $this->db->insert($qr, $pr);
            }
        }

        $qr = "DELETE FROM cart WHERE id_customer = :user";
        $pr = ["user" => 64];
        $code = $this->db->query($qr, $pr);
        if ($code == 0) {
            echo "cart was not deleted";
        }
        return "Заказ номер: $orderId успешно сделан!";
    }
}
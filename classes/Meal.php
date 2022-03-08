<?php
class Meal {

    public function __construct() 
	{
    }

    public function getMealByUser()
    {
        $sql = "SELECT * FROM meal WHERE user_id = ? ORDER BY datetime_served DESC";
        $results = $this->db->query($sql, $this->user_id)->fetchAll();
        return $results;
    }

    public function getMealByMealId()
    {
        $sql = "SELECT * FROM meal WHERE meal_id = ? AND user_id = ?";
        $results = $this->db->query($sql, $this->meal_id, $this->user_id)->fetchAll();
        return $results;
    }

    public function addMeal()
    {
        $sql = "INSERT INTO meal ";
        $sql .= "(user_id, datetime_served, title, ingredients, calories) ";
        $sql .= "VALUES ";
        $sql .= "(?, ?, ?, ?, ?)";
        $results = $this->db->query($sql, $this->user_id, $this->served, $this->title, $this->ingredients, $this->calories);
    }

    public function updateMeal()
    {
        $sql = "UPDATE meal SET ";
        $sql .= "datetime_served = ?,title = ?,ingredients = ?,calories = ? ";
        $sql .= "WHERE meal_id = ? AND user_id = ?";
        $results = $this->db->query($sql, $this->served, $this->title, $this->ingredients, $this->calories, $this->meal_id, $this->user_id);
    }

    public function deleteMeal()
    {
        $sql = "DELETE FROM meal WHERE meal_id = ? AND user_id = ?";
        $results = $this->db->query($sql, $this->meal_id, $this->user_id);
    }

}
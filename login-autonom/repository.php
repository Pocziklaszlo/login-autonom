<?php

class Repository {

    protected $data = null;

    public function __construct($data) {
        $this->data = $data;
    }

    public  function getEmployeeData($page = 0){
      $sql = "SELECT emp.*, dep.dept_name AS 'osztaly' FROM (
            SELECT e.*, sal.salary, til.title FROM employees e INNER JOIN salaries sal ON sal.emp_no = e.emp_no INNER JOIN titles til ON til.emp_no = e.emp_no WHERE sal.to_date AND til.to_date > NOW() GROUP BY e.emp_no
        ) AS emp
            INNER JOIN dept_emp dee ON emp.emp_no = dee.emp_no
            INNER JOIN departments dep ON dee.dept_no = dep.dept_no LIMIT :lmt OFFSET :offset";

        $total = $this->getEmployeeCount()[0]['total'];
        $limit = 20; //getenv('EMPLOYEE_LIMIT');
        $offset = ($page - 1)  * $limit;

        //var_Dump($limit);

        $pages = ceil($total / $limit);

        return [
            'data' => $this->data->selectData($sql,[":lmt" => $limit,":offset" => $offset]),
            'pageData' => [
                'pages' => $pages,
                'total' => $total
            ]
        ];
    }

    public function getEmployeeCount () {
        $totalQuery = "SELECT COUNT(*) AS 'total' FROM (
            SELECT e.*, sal.salary, til.title FROM employees e INNER JOIN salaries sal ON sal.emp_no = e.emp_no INNER JOIN titles til ON til.emp_no = e.emp_no WHERE sal.to_date AND til.to_date > NOW() GROUP BY e.emp_no
        ) AS emp
            INNER JOIN dept_emp dee ON emp.emp_no = dee.emp_no
            INNER JOIN departments dep ON dee.dept_no = dep.dept_no
            LIMIT 1";

        return $this->data->selectData($totalQuery,[]);
    }
}
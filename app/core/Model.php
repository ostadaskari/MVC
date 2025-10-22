<?php
namespace Core;

defined('ROOTPATH') OR exit('Access Denied');
/**
 * Main model Trait
 */
Trait Model
{
    use Database;

    protected $limit        = 10;
    protected $offset       = 0;
    protected $order_type   = "desc";
    protected $order_column = "id";
    public $errors       = [];

    public function findAll()
    {

        $query= "select * from $this->table order by $this->order_column $this->order_type limit $this->limit offset $this->offset";

        return $this->query($query);
    }

    public function where($data, $data_not = []) //data_not is optional
    {
        $keys =     array_keys($data);
        $keys_not = array_keys($data_not);
        $query= "select * from $this->table where ";
        $combinedData = $data; // Start with the main data array

        // Build the query for 'AND' conditions
        foreach($keys as $key){
            $query .= $key . " = :". $key . " && ";
        }

        // Build the query for 'AND NOT' conditions, using a unique placeholder name
        // to prevent collisions when merging the data array.
        foreach($keys_not as $key){
            $placeholder = $key . "_not"; // e.g., id_not
            $query .= $key . " != :". $placeholder . " && ";
            // Add the data to the combined array using the unique placeholder name as the key
            $combinedData[$placeholder] = $data_not[$key];
        }

        $query= trim($query, " && ");
        $query .= " order by $this->order_column $this->order_type limit $this->limit offset $this->offset";

        return $this->query($query, $combinedData);
    }

    public function first($data)
    {
        $keys =     array_keys($data);
        $query= "select * from $this->table where ";
        foreach($keys as $key){
            // Assumes $data is associative (key=column name)
            $query .= $key . " = :". $key . " && ";
        }
        $query= trim($query, " && ");
        $query .= " limit 1 offset $this->offset"; // Limit 1 is sufficient for 'first'

        $result = $this->query($query, $data);
        if($result)
            return $result[0];
        return false;
    }

    public function insert($data)
    {
        /* ---- remove not allowed data -----*/
        if(!empty($this->allowedColumns)){
            foreach($data as $key => $value) {
                if(!in_array($key, $this->allowedColumns)){
                    unset($data[$key]);
                }
            }
        }
        /* --------- */

        $keys = array_keys($data);

        $query= "insert into $this->table (".implode(",",$keys).") values (:".implode(",:",$keys).") ";
        $this->query($query, $data);
        return false;
    }

    public function update($id, $data, $id_column = 'id')
    {
        /* ---- remove not allowed data -----*/
        if(!empty($this->allowedColumns)){
            foreach($data as $key => $value) {
                if(!in_array($key, $this->allowedColumns)){
                    unset($data[$key]);
                }
            }
        }
        /* --------- */

        $keys = array_keys($data);
        $query= "update $this->table set ";
        foreach($keys as $key){
            $query .= $key . " = :". $key . ", ";
        }

        $query= trim($query, ", ");
        $query .= " where $id_column = :$id_column";

        $data[$id_column] = $id;
        //echo query
        $this->query($query, $data);
        return false;
    }

    public function delete($id, $id_column = 'id')
    {

        $data[$id_column] = $id;
        $query= "delete from $this->table where $id_column = :$id_column ";
        $this->query($query, $data);
        return false;
    }

    public function getError($key){

        if(!empty($this->errors[$key]))
            return $this->errors[$key];

        return "";
    }

    protected function get_primary_key(){
        return $this->primaryKey ?? 'id';
    }

    public function validate($data){
        $this->errors = [];

        if (!empty($this->validationRules)){
            foreach($this->validationRules as $column => $rules){

                // CRITICAL FIX: Skip validation if the data key is not present,
                // preventing 'Undefined array key' warnings on GET requests.
                if (!isset($data[$column])) {
                    // If a required field is missing, we will catch it below,
                    // but we can't run checks like 'email' or 'unique' if the data is not there.
                    continue;
                }

                foreach ($rules as $rule){
                    switch ($rule){
                        case 'required':
                            if(empty($data[$column]))
                                $this->errors[$column] = ucfirst($column)." is required";
                            break;

                        case 'email':
                            if(!filter_var(trim($data[$column]), FILTER_VALIDATE_EMAIL))
                                $this->errors[$column] = "EMAIL is not valid";
                            break;

                        case 'alpha':
                            if(!preg_match("/^([a-zA-Z])+$/",trim($data[$column])))
                                $this->errors[$column] = ucfirst($column)." should only contain alphabetical characters without spaces";
                            break;

                        case 'alpha_space':
                            if(!preg_match("/^([a-zA-Z ])+$/",trim($data[$column])))
                                $this->errors[$column] = ucfirst($column)." should only contain alphabetical characters & space";
                            break;

                        case 'alpha_numeric':
                            if(!preg_match("/^([a-zA-Z0-9])+$/",trim($data[$column])))
                                $this->errors[$column] = ucfirst($column)." should only contain alphabetical characters & space";
                            break;

                        case 'alpha_numeric_symbol':
                            if(!preg_match("/^([a-zA-Z0-9\-\_\$\%\*\[\]\(\)\& ])+$/",trim($data[$column])))
                                $this->errors[$column] = ucfirst($column)." should only contain alphabetical characters & space";
                            break;

                        case 'alpha_symbol':
                            if(!preg_match("/^([a-zA-Z\-\_\$\%\*\[\]\(\)\& ])+$/",trim($data[$column])))
                                $this->errors[$column] = ucfirst($column)." should only contain alphabetical characters & space";
                            break;

                        case 'longer_than_8_characters':
                            if(strlen(trim($data[$column])) < 8)
                                $this->errors[$column] = ucfirst($column)." should not be less than 8 characters";
                            break;

                        case 'unique':
                            // FIX: Ensure an associative array is passed for database checks.
                            $pkey =$this->get_primary_key();
                            $checkData = [$column => $data[$column]];
                            $result = false;

                            if(!empty($data[$pkey])){
                                // Edit mode: check for uniqueness while excluding the current record's primary key
                                $excludeData = [$pkey => $data[$pkey]];
                                $result = $this->where($checkData, $excludeData); // Use where() with the exclusion data
                            } else {
                                // Insert mode: check for uniqueness
                                $result = $this->first($checkData);
                            }

                            if($result){
                                $this->errors[$column] = ucfirst($column)." should be unique";
                            }
                            break;

                        default:
                            $this->errors['rules'] = "The rule ". $rule . " was not found";
                            break;
                    }
                }
            }
        }

        if(empty($this->errors)){
            return true;
        }
        return false;
    }

}

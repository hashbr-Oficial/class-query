<?php

//namespace to organize

namespace Query_src;

/**
 * Class Query Where
 * @author Bruno Ribeiro <bruno.espertinho@gmail.com>
 * @author Zachbor       <zachborboa@gmail.com>
 * 
 * @version 3.4
 * @access public
 * @package Where
 * @subpackage Pagination
 */
class Where extends Pagination {

    /**
     * Get where SQL command 
     * 
     * @access protected
     * @return string
     */
    protected function get_where() {
        if (!empty($where = $this->_get_where()))
            $wheres[] = $where;

        if (!empty($where = $this->get_where_equal()))
            $wheres[] = $where;

        if (!empty($where = $this->get_where_equal_or()))
            $wheres[] = $where;

        if (!empty($where = $this->get_where_not_equal()))
            $wheres[] = $where;

        if (!empty($where = $this->get_where_not_in()))
            $wheres[] = $where;

        if (!empty($where = $this->get_where_in()))
            $wheres[] = $where;

        if (!empty($where = $this->get_where_like_both()))
            $wheres[] = $where;

        if (!empty($where = $this->get_where_like_before()))
            $wheres[] = $where;

        if (!empty($where = $this->get_where_like_after()))
            $wheres[] = $where;

        if (!empty($where = $this->get_where_like_or()))
            $wheres[] = $where;

        if (!empty($where = $this->get_where_less_than_or_equal_to()))
            $wheres[] = $where;

        if (!empty($where = $this->get_where_greater_than_or_equal_to()))
            $wheres[] = $where;

        if (!empty($where = $this->get_where_greater_than()))
            $wheres[] = $where;

        if (!empty($where = $this->get_where_less_than()))
            $wheres[] = $where;

        if (!empty($where = $this->get_where_like_binary()))
            $wheres[] = $where;

        if (empty($wheres))
            return '';

        $command = sprintf("\nWHERE \n\t %s", implode(" AND \n\t", $wheres));
        return $command;
    }

    /**
     * Custom criteria where
     * 
     * @version 0.2
     * @return string
     */
    private function _get_where() {
        if (!isset($this->where)) {
            return '';
        }
        if (!is_array($this->where)) {
            return $this->where;
        }
        return implode(' AND' . "\n\t", $this->where) . ' ';
    }

    private function get_where_like_binary() {
        $where = [];
        if (!empty($this->where_like_binary)) {
            if (is_array($this->where_like_binary)) {
                foreach ($this->where_like_binary as $k => $v) {
                    if (!empty($v) && !is_null($v))
                        $v = $this->safe_value_where_like($v);
                    else
                        $v = "";
                    $kk = $this->type == "postgresql" ? $k : (preg_match("/\./", $k) ? $k : "`{$k}`");
                    $function = "LIKE";
                    if ($this->type == "postgresql")
                        $function = "ILIKE";
                    $where[] = "{$kk} {$function} BINARY \"{$v}\"";
                }
            } else {
                $where = $this->where_like_binary;
            }
        }
        return count($where) > 0 ? implode(" AND \n\t", $where) : (!is_array($where) ? $where : '');
    }

    private function get_where_like_or() {
        $where = [];
        if (!empty($this->where_like_or)) {
            if (is_array($this->where_like_or)) {
                foreach ($this->where_like_or as $k => $v) {
                    if (!empty($v) && !is_null($v))
                        $v = $this->safe_value_where_like($v);
                    else
                        $v = "";
                    $kk = $this->type == "postgresql" ? $k : (preg_match("/\./", $k) ? $k : "`{$k}`");
                    $function = "LIKE";
                    if ($this->type == "postgresql")
                        $function = "ILIKE";
                    $where[] = "{$kk} {$function} \"%{$v}%\"";
                }
            } else {
                $where = $this->where_like_or;
            }
        }
        return count($where) > 0 ? sprintf("(%s)", implode(" OR \n\t", $where)) : (!is_array($where) ? $where : '');
    }

    private function get_where_like_before() {
        $where = [];
        if (!empty($this->where_like_before)) {
            if (is_array($this->where_like_before)) {
                foreach ($this->where_like_before as $k => $v) {
                    if (!empty($v) && !is_null($v))
                        $v = $this->safe_value_where_like($v);
                    else
                        $v = "";
                    $kk = $this->type == "postgresql" ? $k : (preg_match("/\./", $k) ? $k : "`{$k}`");
                    $function = "LIKE";
                    if ($this->type == "postgresql")
                        $function = "ILIKE";
                    $where[] = "{$kk} {$function} \"%{$v}\"";
                }
            } else {
                $where = $this->where_like_before;
            }
        }
        return count($where) > 0 ? implode(" AND \n\t", $where) : (!is_array($where) ? $where : '');
    }

    private function get_where_like_after() {
        $where = [];
        if (!empty($this->where_like_after)) {
            if (is_array($this->where_like_after)) {
                foreach ($this->where_like_after as $k => $v) {
                    if (!empty($v) && !is_null($v))
                        $v = $this->safe_value_where_like($v);
                    else
                        $v = "";
                    $kk = $this->type == "postgresql" ? $k : (preg_match("/\./", $k) ? $k : "`{$k}`");
                    $function = "LIKE";
                    if ($this->type == "postgresql")
                        $function = "ILIKE";
                    $where[] = "{$kk} {$function} \"{$v}%\"";
                }
            } else {
                $where = $this->where_like_after;
            }
        }
        return count($where) > 0 ? implode(" AND \n\t", $where) : (!is_array($where) ? $where : '');
    }

    private function get_where_like_both() {
        $where = [];
        if (!empty($this->where_like_both)) {
            if (is_array($this->where_like_both)) {
                foreach ($this->where_like_both as $k => $v) {
                    if (!empty($v) && !is_null($v))
                        $v = $this->safe_value_where_like($v);
                    else
                        $v = "";
                    $kk = $this->type == "postgresql" ? $k : (preg_match("/\./", $k) ? $k : "`{$k}`");
                    $function = "LIKE";
                    if ($this->type == "postgresql")
                        $function = "ILIKE";
                    $where[] = "{$kk} {$function} \"%{$v}%\"";
                }
            } else {
                $where = $this->where_like_both;
            }
        }
        return count($where) > 0 ? implode(" AND \n\t", $where) : (!is_array($where) ? $where : '');
    }

    private function get_where_equal() {
        $where = [];
        $reserved = ["MONTH", "YEAR", "DAY", "DATE"];
        if (!empty($this->where_equal_to)) {
            if (is_array($this->where_equal_to)) {
                foreach ($this->where_equal_to as $k => $v) {
                    $res = false;
                    // date mysql reserved words
                    foreach ($reserved as $r) {
                        if (preg_match(sprintf("/%s/", strtolower($r)), strtolower($k))) {
                            $res = true;
                            break;
                        }
                    }
                    $kk = preg_match("/\./", $k) ? $k : ($res ? $k : "`{$k}`");
                    if ($this->type == "postgresql")
                        $kk = preg_match("/\./", $k) ? $k : ($res ? $k : "{$k}");

                    $where[] = is_null($v) ? "{$kk} IS NULL" : "{$kk} = {$this->safe_value($v)}";
                }
            } else {
                $where = $this->where_equal_to;
            }
        }
        return count($where) > 0 ? implode(" AND \n\t", $where) : (!is_array($where) ? $where : '');
    }

    private function get_where_less_than_or_equal_to() {
        $where = [];
        if (!empty($this->where_less_than_or_equal_to)) {
            if (is_array($this->where_less_than_or_equal_to)) {
                foreach ($this->where_less_than_or_equal_to as $k => $v) {
                    $kk = preg_match("/\./", $k) ? $k : "`{$k}`";
                    $where[] = "{$kk} <= {$this->safe_value($v)}";
                }
            } else {
                $where = $this->where_less_than_or_equal_to;
            }
        }
        return count($where) > 0 ? implode(" AND \n\t", $where) : (!is_array($where) ? $where : '');
    }

    private function get_where_greater_than_or_equal_to() {
        $where = [];
        if (!empty($this->where_greater_than_or_equal_to)) {
            if (is_array($this->where_greater_than_or_equal_to)) {
                foreach ($this->where_greater_than_or_equal_to as $k => $v) {
                    $kk = preg_match("/\./", $k) ? $k : "`{$k}`";
                    $where[] = "{$kk} >= {$this->safe_value($v)}";
                }
            } else {
                $where = $this->where_greater_than_or_equal_to;
            }
        }
        return count($where) > 0 ? implode(" AND \n\t", $where) : (!is_array($where) ? $where : '');
    }

    private function get_where_greater_than() {
        $where = [];
        if (!empty($this->where_greater_than)) {
            if (is_array($this->where_greater_than)) {
                foreach ($this->where_greater_than as $k => $v) {
                    $kk = preg_match("/\./", $k) ? $k : "`{$k}`";
                    $where[] = "{$kk} > {$this->safe_value($v)}";
                }
            } else {
                $where = $this->where_greater_than;
            }
        }
        return count($where) > 0 ? implode(" AND \n\t", $where) : (!is_array($where) ? $where : '');
    }

    private function get_where_less_than() {
        $where = [];
        if (!empty($this->where_less_than)) {
            if (is_array($this->where_less_than)) {
                foreach ($this->where_less_than as $k => $v) {
                    $kk = preg_match("/\./", $k) ? $k : "`{$k}`";
                    $where[] = "{$kk} < {$this->safe_value($v)}";
                }
            } else {
                $where = $this->where_less_than;
            }
        }
        return count($where) > 0 ? implode(" AND \n\t", $where) : (!is_array($where) ? $where : '');
    }

    private function get_where_not_equal() {
        $where = [];
        if (!empty($this->where_not_equal_to)) {
            if (is_array($this->where_not_equal_to)) {
                foreach ($this->where_not_equal_to as $k => $v) {
                    $kk = $this->type == "postgresql" ? $k : (preg_match("/\./", $k) ? $k : "`{$k}`");
                    $where[] = is_null($v) ? "{$kk} IS NOT NULL" : "{$kk} != {$this->safe_value($v)}";
                }
            } else {
                $where = $this->where_not_equal_to;
            }
        }
        return count($where) > 0 ? implode(" AND \n\t", $where) : (!is_array($where) ? $where : '');
    }

    private function get_where_equal_or() {
        $where = [];
        if (!empty($this->where_equal_or)) {
            if (is_array($this->where_equal_or)) {
                foreach ($this->where_equal_or as $k => $v) {
                    $kk = $this->type == "postgresql" ? $k : (preg_match("/\./", $k) ? $k : "`{$k}`");
                    $where[] = is_null($v) ? "{$kk} IS NULL" : "{$kk} = {$this->safe_value($v)}";
                }
            } else {
                $where = $this->where_equal_or;
            }
        }
        return count($where) > 0 ? sprintf("(%s)", implode(" OR \n\t", $where)) : (!is_array($where) ? $where : '');
    }

    private function get_where_not_in() {
        $where = [];
        if (!empty($this->where_not_in)) {
            if (is_array($this->where_not_in)) {
                foreach ($this->where_not_in as $k => $v) {
                    $vv = [];
                    if (is_array($v)) {
                        foreach ($v as $value) {
                            $vv[] = $this->safe_value($value);
                        }
                    } else {
                        $vv[] = $v;
                    }
                    $final = implode(",", $vv);
                    $kk = preg_match("/\./", $k) ? $k : "`{$k}`";
                    $where[] = "{$kk} NOT IN ({$final})";
                }
            } else {
                $where = $this->where_not_in;
            }
        }
        return count($where) > 0 ? implode(" AND \n\t", $where) : (!is_array($where) ? $where : '');
    }

    private function get_where_in() {
        $where = [];
        if (!empty($this->where_in)) {
            if (is_array($this->where_in)) {
                foreach ($this->where_in as $k => $v) {
                    $vv = [];
                    if (is_array($v)) {
                        foreach ($v as $value) {
                            $vv[] = $this->safe_value($value);
                        }
                    } else {
                        $vv[] = $v;
                    }
                    $final = implode(",", $vv);
                    $kk = $this->type == "postgresql" ? $k : (preg_match("/\./", $k) ? $k : "`{$k}`");
                    $where[] = "{$kk} IN ({$final})";
                }
            }
        }
        return count($where) > 0 ? implode(" AND \n\t", $where) : (!is_array($where) ? $where : '');
    }

    /**
     * Safe value for SQL 
     * 
     * @param mixed $v
     * @return mixed
     */
    protected function safe_value_where_like($v) {
        if ($this->type == "postgresql") {
            if (is_bool($v))
                return (int) $v;

            if (is_string($v))
                return sprintf("'%s'", str_replace("'", "''", $v));

            if (is_int($v) || is_numeric($v))
                return $v;

            return $v;
        }
        if (is_bool($v))
            return (int) $v;

        if (is_numeric($v) && !in_array(substr($v, 0, 1), ["0", 0]))
            return str_replace(",", ".", $v);

        if (is_string(strval($v)))
            return sprintf("%s", str_replace("'", "\'", $v));

        return $v;
    }

    /**
     * Safe value for SQL 
     * 
     * @param mixed $v
     * @return mixed
     */
    protected function safe_value($v) {
        if ($this->type == "postgresql") {
            if (is_bool($v))
                return (int) $v;

            if (is_string($v))
                return sprintf("'%s'", str_replace("'", "''", $v));

            if (is_int($v) || is_numeric($v))
                return $v;

            return $v;
        }
        if (is_bool($v))
            return (int) $v;

        if (is_numeric($v) && !in_array(substr($v, 0, 1), ["0", 0]))
            return str_replace(",", ".", $v);

        if (is_string(strval($v)))
            return sprintf("'%s'", str_replace("'", "\'", $v));

        return $v;
    }

    /**
     * Safe value for SQL 
     * 
     * @param mixed $v
     * @return mixed
     */
    protected function safeColumn($value) {
        if ($this->type == "postgresql")
            return str_replace("`", '', $value);

        $c = str_replace("`", '', $value);
        return "`{$c}`";
    }

}

<?php


namespace App\Utils\Filters;


class FilterBuilder
{
    protected $query;
    protected $filters;
    protected $namespace;

    public function __construct($query, $filters, $namespace)
    {
        $this->query = $query;
        $this->filters = $filters;
        $this->namespace = $namespace;
    }

    public function apply()
    {

        foreach ($this->filters as $name => $value) {

            if (str_contains($name, '_')) {
                $normailizedName = implode("", array_map('ucfirst', explode("_", $name)));
            }
            $normailizedName = $this->normailizeName($name);
            $class = $this->namespace . "\\{$normailizedName}";

            if (!class_exists($class)) {
                continue;
            }
            $check_count = is_array($value) ? count($value) : strlen($value);
            if ($check_count) {
                (new $class($this->query))->handle($value);
            } else {
                (new $class($this->query))->handle();
            }
        }

        return $this->query;
    }

    private function normailizeName($name)
    {
        $newName = ucfirst($name);

        if (str_contains($name, "_")) {
            $newName = implode("", array_map('ucfirst', explode("_", $name)));
        }

        return $newName;
    }
}

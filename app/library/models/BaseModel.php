<?php

namespace WBDB\Models;

use DB;
use Eloquent;
use Hash;
use Input;
use Validator;

Class BaseModel extends Eloquent
{
    public $enableValidator = true;
    protected $fillable = null;
    public $guarded = array(
        'csrf_token',
        '_token',
        '_method'
    );
    public $clean = array(
        'csrf_token',
        '_token',
        '_method'
    );
    public static $messages = array();
    private $alt_rules = null;
    private $errors = null;

    /**
     * Attach a listener via the Eloquent::boot function for
     * when models are saved.
     */
    public static function boot()
    {
        parent::boot();

        // If we're saving the model, validate it first.
        static::saving(
            function ($model) {
                return $model->validate();
            }
        );

        // If we're updating the model, validate it first.
        static::updating(
            function ($model) {
                return $model->validate();
            }
        );

    }

    /**
     * Return the errors from validation
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Set an alternate ruleset
     */
    public function setRules($rules)
    {
        $this->alt_rules = $rules;
    }

    /**
     * Validate using the static set of rules, add messages
     *
     * @return boolean
     */
    public function validate(array $rules = array())
    {

        if (!$this->enableValidator) {
            return true;
        }

        if (isset($this->alt_rules) && count($rules) == 0) {
            $rules = $this->alt_rules;
        }

        $rules = self::processRules($rules ? $rules : static::$rules);

        $validator = Validator::make(Input::all(), $rules, static::$messages ?: array());

        if ($validator->passes()) {
            $this->processIgnores();
            return true;
        }

        $this->errors = $validator->messages();
        return false;
    }

    /**
     * Process validation rules and replace ID's in "unique" rules.
     */
    protected function processRules(array $rules)
    {
        // If the ID is null, it's a new Model, so let's strip out the id
        // completely.
        $id = $this->getKey();
        $replacement = $id == null ? "" : "," . $id;

        array_walk(
            $rules,
            function (&$item) use ($replacement) {
                // Replace placeholders
                $item = stripos($item, ',:id:') !== false ? str_ireplace(',:id:', $replacement, $item) : $item;
            }
        );

        return $rules;
    }

    /**
     * Removes any attributes from the model that should be ignored and not saved
     */
    private function processIgnores()
    {
        $cleaning = isset(static::$clean) ? array_merge(static::$clean, $this->clean) : $this->clean;
        foreach ($cleaning as $attr) :
            unset($this->$attr);
        endforeach;
    }

}

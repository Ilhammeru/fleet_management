<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class FormGroup extends Component
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $className;

    /**
     * @var string
     */
    public $label;

    /**
     * @var bool
     */
    public $isRequired;

    /**
     * @var bool
     */
    public $showErrorComponent;

    /**
     * @var string
     */
    public $inputType;

    /**
     * @var string
     */
    public $fieldType;

    /**
     */
    public $selectOptions;

    /**
     * @var string
     */
    public $placeholder;

    public $radioOptions;

    public $value;

    public $formModel;

    public $inputDescription;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $name,
        string $label,
        string $fieldType = 'input',
        string $placeholder = null,
        string $inputType = 'text',
        bool $showErrorComponent = true,
        bool $isRequired = false,
        string $className = null,
        $selectOptions = null,
        $value = null,
        $radioOptions = null,
        $formModel = 'classic',
        $inputDescription = null,
    )
    {
        $this->name = $name;
        $this->className = $className;
        $this->label = $label;
        $this->isRequired = $isRequired ? 'required' : '';
        $this->showErrorComponent = $showErrorComponent;
        $this->inputType = $inputType;
        $this->fieldType = $fieldType;
        $this->selectOptions = $selectOptions;
        $this->value = $value;
        $this->placeholder = $placeholder ? $placeholder : $label;
        $this->radioOptions = $radioOptions;
        $this->formModel = $formModel;
        $this->inputDescription = $inputDescription;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        if ($this->formModel == 'classic') {
            return view('components.form.form-group-classic');
        } else if ($this->formModel == 'classic-inline') {
            return view('components.form.form-group');
        } else if ($this->formModel == 'modern') {
            return view('components.form.form-group-modern');
        }
    }
}

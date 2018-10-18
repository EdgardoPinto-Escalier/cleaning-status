<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: formValidations.class.php
/////////////////////////////////////////////

//This class will help us to check and validate if different
//sorts of validations has passed. This class will help to validate
//things quickly.

//First we define the class.
class formValidations {
	//Next we declare 3 private properties.
	private $_passed = false, //By default we assume that is not passed.
			$_errors = array(),
			$_database = null;
	//Next we create the constructor. This will be called when this
	//class is instantiated.
	public function __construct() {
		$this->_database = dbConnection::getInstance();
	}
	//Next we create the verify method.
	public function verify($source, $items = array()) {
		//Next we create a foreach loop to go trough
		//the items and rules defined. 
		foreach($items as $item => $formRules) {
			foreach($formRules as $formRule => $formRuleValue) {
				//Next we get the value of each item.
				$myValue = trim($source[$item]);
				$item = security($item);
				//If the rule is required and the value is empty...
				if($formRule === 'required' && empty($myValue)) {
					
        			
					//We attach the ruleError method to it and the message.
					$this->ruleError("swal('Warning', 'The {$item} field is required...','warning');");
				//If not empty
				} else if(!empty($myValue)) {
					//We switch the rule with the different cases.
					switch($formRule) {
						//Case for minValue goes here.
						case 'minValue':
							//If string length is less then formRuleValue...
							if(strlen($myValue) < $formRuleValue) {
								//Then we attach the ruleError with the message.
								$this->ruleError("swal('Warning!', 'The {$item} must contain a minimum of {$formRuleValue} characters...', 'warning');");
							}
						break;
						//Case for maxValue goes here.
						case 'maxValue':
							//If string length is greater then formRuleValue...
							if(strlen($myValue) > $formRuleValue) {
								//Then we attach the ruleError with the message.
								$this->ruleError("swal('Warning!', 'The {$item} must be a maximum of {$formRuleValue} characters...', 'warning');");
							}
						break;
						//Case for uniqueName goes here.
						case 'uniqueName':
							//Here we verify using an instance of the database if the value does exist there...
							$verifyDB = $this->_database->getData($formRuleValue, array($item, '=', $myValue));
							//If there is a count means that the value does exist...
							if($verifyDB->dbCount()) {
								//Then we attach the ruleError with the message.
								$this->ruleError("swal('Warning!', 'This {$item} already exists...', 'warning');");
							}
						break;	
					}
				}
			}
		}
		//After we had looped and validated through everything,
		//we'll do a quick check if the errors array is empty or not...
		if(empty($this->_errors)) {
			//If it's empty we say true because there is not errors stored.
			$this->_passed = true;
		}
		return $this;
	}

	//Here we create the ruleError method. This will
	//attach the error to the array.
	private function ruleError($error) {
		$this->_errors[] = $error;
	}

	//Next we create the errorList method. This method
	//will return a list of errors we may have.
	public function errorList() {
		return $this->_errors;
	}

	//Next we create the passedRule method. This will 
	//return _passed.
	public function passedRule() {
		return $this->_passed;
	}
}
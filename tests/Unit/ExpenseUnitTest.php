<?php

namespace Tests\Unit;

use App\Http\Controllers\Expense\CheckInput;
use Tests\TestCase;

class ExpenseUnitTest extends TestCase
{
    /**
     * name,amount,userId
     */
    public function test_createEndpoint_should_throw_error_user_not_provide_inputs(): void
    {
        // ['name is required', 'amount is required', 'userId is']
        $validate = CheckInput::validate([]);

        $errors = $validate->original;

        $this->assertEquals(3, count($errors['errors']));
    }

    public function test_createEndpoint_amount_is_valid_number(): void
    {

        $validate = CheckInput::validate([
            'name' => 'food',
            'amount' => 'dksks',
            'userId' => 1,
        ]);
        // ['amount is not a number']:1

        $errors = $validate->original;

        $this->assertEquals(1, count($errors['errors']));
    }

    public function test_createEndpoint_name_is_greater_than_15_chars(): void
    {

        $validate = CheckInput::validate([
            'name' => str_repeat('electriticty', 20),
            'amount' => 22,
            'userId' => 1,
        ]);
        // ['name must be less than 15']:1

        $errors = $validate->original;

        $this->assertEquals(1, count($errors['errors']));
    }

    /**
     * id,name,amount,userId
     */
    public function test_updateEndpoint_should_throw_error_user_not_provide_inputs(): void
    {
        // ['name is required', 'amount is required', 'userId is']
        $validate = CheckInput::validateUpdate([]);

        $errors = $validate->original;

        $this->assertEquals(4, count($errors['errors']));
    }

    public function test_updateEnpoint_id_is_valid_number(): void
    {

        $validate = CheckInput::validateUpdate([
            'id' => 'id',
            'name' => 'food',
            'amount' => 22,
            'userId' => 1,
        ]);
        // ['id is not a number']:1

        $errors = $validate->original;

        $this->assertEquals(1, count($errors['errors']));
    }

    public function test_updateEnpoint_amount_is_valid_number(): void
    {

        $validate = CheckInput::validateUpdate([
            'id' => 12,
            'name' => 'food',
            'amount' => 'dkdkd',
            'userId' => 1,
        ]);
        // ['id is not a number']:1

        $errors = $validate->original;

        $this->assertEquals(1, count($errors['errors']));
    }

    public function test_updateEndpoint_name_is_greater_than_15_chars(): void
    {

        $validate = CheckInput::validate([
            'id' => 1,
            'name' => str_repeat('food', 25),
            'amount' => 22,
            'userId' => 1,
        ]);
        // ['name must be less than 15']:1

        $errors = $validate->original;

        $this->assertEquals(1, count($errors['errors']));
    }
}

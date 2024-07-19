<?php

namespace Tests\Feature\Livewire\Survey;

use App\Livewire\Survey\DimensionsList;
use App\Models\Dimension;
use App\Models\Question;
use App\Models\Subdimension;
use Livewire\Livewire;
use Tests\TestCase;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DimensionsListTest extends TestCase
{
    // use RefreshDatabase;

    /** @test */
    public function viewPage()
    {
        Livewire::test(DimensionsList::class)
            ->assertStatus(200);
    }

    /** @test */
    // kategori dimension create unit
    public function createDimension(): void
    {
        $faker = Factory::create();
        $name = $faker->name;
        $description = $faker->sentence;
        Livewire::test(DimensionsList::class)
            ->set('name', $name)
            ->set('description', $description)
            ->call('create');

        $this->assertDatabaseHas('dimensions', [
            'name' => $name,
            'description' => $description,
        ]);
    }

    /** @test */
    // dimension create unit
    public function createSubdimension(): void
    {
        $faker = \Faker\Factory::create();
        $name = $faker->name;
        $description = $faker->sentence;
        $dimension = Dimension::inRandomOrder()->first();

        Livewire::test(DimensionsList::class)
            ->set('dimensionID', $dimension->id)
            ->set('subdimensionName', $name)
            ->set('subdimensionDescription', $description)
            ->call('createSubdimension');

        $this->assertDatabaseHas('subdimensions', [
            'name' => $name,
            'description' => $description,
            'dimension_id' => $dimension->id,
        ]);
    }

    /** @test */
    // dimension delete unit
    public function it_deletes_subdimension_without_questions(): void
    {
        // Create a subdimension without questions
        $subdimension = Subdimension::factory()->create();

        // Test deleting the subdimension
        Livewire::test(DimensionsList::class)
            ->call('deleteSubdimension', $subdimension->id);

        // Assert that the subdimension was deleted from the database
        $this->assertDatabaseMissing('subdimensions', [
            'id' => $subdimension->id,
        ]);
    }

    /** @test */
    // dimensi delete unit
    public function it_cannot_delete_subdimension_with_questions(): void
    {
        // Create a subdimension with questions
        $subdimension = Subdimension::factory()->create();
        $question = Question::factory()->create(['subdimension_id' => $subdimension->id]);

        // Test trying to delete the subdimension
        Livewire::test(DimensionsList::class)
            ->call('deleteSubdimension', $subdimension->id);

        // Assert that the subdimension still exists in the database
        $this->assertDatabaseHas('subdimensions', [
            'id' => $subdimension->id,
        ]);
    }


    /** @test */
    // Manajemen dimensi create integration
    public function it_creates_dimension_and_subdimension(): void
    {


        // Generate test data using Faker
        $faker = \Faker\Factory::create();
        $dimensionName = $faker->name;
        $dimensionDescription = $faker->sentence;

        // Step 1: Create a dimension
        $livewire = Livewire::test(DimensionsList::class)
            ->set('name', $dimensionName)
            ->set('description', $dimensionDescription)
            ->call('create');

        // Assert that the dimension is in the database
        $this->assertDatabaseHas('dimensions', [
            'name' => $dimensionName,
            'description' => $dimensionDescription,
        ]);

        // Fetch the newly created dimension
        $dimension = Dimension::where('name', $dimensionName)->first();

        // Generate test data for subdimension
        $subdimensionName = $faker->name;
        $subdimensionDescription = $faker->sentence;

        // Step 2: Create a subdimension associated with the created dimension
        $livewire->set('dimensionID', $dimension->id)
            ->set('subdimensionName', $subdimensionName)
            ->set('subdimensionDescription', $subdimensionDescription)
            ->call('createSubdimension');

        // Assert that the subdimension is in the database
        $this->assertDatabaseHas('subdimensions', [
            'name' => $subdimensionName,
            'description' => $subdimensionDescription,
            'dimension_id' => $dimension->id,
        ]);
    }

    /** @test */
    // Kategori dimension update unit
    public function it_can_update_dimension_description(): void
    {
        // Create a dimension
        $dimension = Dimension::factory()->create([
            'description' => 'Old Description',
        ]);

        // New description to update
        $newDescription = 'New Description';

        // Test updating the dimension description
        Livewire::test(DimensionsList::class)
            ->set('editingDimensionDescription', $newDescription)
            ->call('update', $dimension->id);

        // Assert that the dimension's description was updated in the database
        $this->assertDatabaseHas('dimensions', [
            'id' => $dimension->id,
            'description' => $newDescription,
        ]);
    }

    /** @test */
    // manajemen dimensi delete integration
    public function it_deletes_dimension_without_subdimensions(): void
    {
        // Create a dimension without subdimensions
        $dimension = Dimension::factory()->create();

        // Test deleting the dimension
        Livewire::test(DimensionsList::class)
            ->call('delete', $dimension->id);

        // Assert that the dimension was deleted from the database
        $this->assertDatabaseMissing('dimensions', [
            'id' => $dimension->id,
        ]);
    }

    /** @test */
    // manajemen dimensi delete integration
    public function it_deletes_dimension_with_subdimensions_without_questions(): void
    {
        // Create a dimension with subdimensions without questions
        $dimension = Dimension::factory()->create();
        $subdimension = Subdimension::factory()->create(['dimension_id' => $dimension->id]);

        // Test deleting the dimension
        Livewire::test(DimensionsList::class)
            ->call('delete', $dimension->id);

        // Assert that the dimension and its subdimensions were deleted from the database
        $this->assertDatabaseMissing('dimensions', [
            'id' => $dimension->id,
        ]);
        $this->assertDatabaseMissing('subdimensions', [
            'id' => $subdimension->id,
        ]);
    }

    /** @test */
    // manajemen dimensi delete integration
    public function it_cannot_delete_dimension_with_subdimensions_with_questions(): void
    {
        // Create a dimension with subdimensions with questions
        $dimension = Dimension::factory()->create();
        $subdimension = Subdimension::factory()->create(['dimension_id' => $dimension->id]);
        $question = Question::factory()->create(['subdimension_id' => $subdimension->id]);

        // Test trying to delete the dimension
        Livewire::test(DimensionsList::class)
            ->call('delete', $dimension->id);

        // Assert that the dimension and its subdimensions still exist in the database
        $this->assertDatabaseHas('dimensions', [
            'id' => $dimension->id,
        ]);
        $this->assertDatabaseHas('subdimensions', [
            'id' => $subdimension->id,
        ]);
        $this->assertDatabaseHas('questions', [
            'id' => $question->id,
        ]);
    }
}
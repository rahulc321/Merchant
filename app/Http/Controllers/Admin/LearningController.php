<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\LearningCollection;
use App\LearningItem;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LearningController extends Controller
{
    // Show the form to create a new learning collection
    public function create()
    {
        return view('learning.index');
    }

    // Store a new learning collection
    public function store(Request $request)
    {
        //dd(1);
        // Validate the incoming data
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string'
        ]);

        // Create the learning collection
        $collection = LearningCollection::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        // Redirect to the add items form for the newly created collection
        return redirect()->route('admin.learning.addItemsForm', $collection->id);
    }

    // Show the form to add items to a specific learning collection
    public function addItems($id)
    {
        // Find the collection by ID
        $collection = LearningCollection::findOrFail($id);

        // Show the form to add items
        return view('admin.training.create', compact('collection'));
    }

    // Store the items (text, image, video, question) in the learning collection
    public function storeItems(Request $request, $id)
    {
       
        // Validate the incoming data
        // $request->validate([
        //     'items' => 'required|array',
        //     'items.*.type' => 'required|in:text,image,video,question',
        //     'items.*.order' => 'required|integer',
        //     'items.*.question_text' => 'required_if:items.*.type,question|string',
        //     'items.*.correct_option' => 'required_if:items.*.type,question|string',
        //     'items.*.options' => 'required_if:items.*.type,question|array',
        //     'items.*.options.*.key' => 'required_with:items.*.options|string',
        //     'items.*.options.*.option' => 'required_with:items.*.options|string',
        // ]);

         
            // Find the collection by ID
            $collection = LearningCollection::findOrFail($id);

            // Loop through each item and store it in the collection
            foreach ($request->items as $itemData) {
                $item = new LearningItem([
                    'type' => $itemData['type'],
                    'content' => $itemData['content'] ?? null,
                    'order' => $itemData['order'],
                ]);

                // Save the item to the collection
                $collection->items()->save($item);

                // If the item type is a question, handle the question-related data
                if ($itemData['type'] === 'question') {
                    $question = new Question([
                        'question' => $itemData['question_text'],
                        'correct_option' => $itemData['correct_option'],
                    ]);

                    // Save the question for the item
                    $item->question()->save($question);

                    // Save the options for the question
                    foreach ($itemData['options'] as $opt) {
                        $question->options()->create([
                            'key' => $opt['key'],
                            'option' => $opt['option'],
                        ]);
                    }
                }
            }
            dd(2);
            // Redirect to a success page (or back to the add items form)
            return redirect()->route('learning.create')->with('success', 'Items added successfully');
        
    }
}

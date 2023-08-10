<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
use Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Candidate;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Phone;
use App\Models\Education;

class CandidateController extends Controller
{

    /**
 * @OA\Post(
 *     path="/v1/candidates",
 *     summary="Save a candidate",
 *     operationId="saveCandidate",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="first_name", type="string"),
 *             @OA\Property(property="last_name", type="string"),
 *             @OA\Property(property="age", type="integer"),
 *             @OA\Property(property="department", type="string"),
 *             @OA\Property(property="min_salary_expectation", type="number"),
 *             @OA\Property(property="max_salary_expectation", type="number"),
 *             @OA\Property(property="currency_id", type="string"),
 *             @OA\Property(property="address_id", type="string"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful response"
 *     ),
 *     @OA\Header(
 *         header="Authorization",
 *         description="Bearer {access_token}",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     )
 * )
 */
    function store(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name'             => 'required|string',
            'last_name'              => 'required|string',
            'age'                    => 'required|integer',
            'department'             => 'required|string',
            'min_salary_expectation' => 'required|numeric',
            'max_salary_expectation' => 'required|numeric',

            'currency_id'            => 'required|exists:currency_t,id',
            'address_id'             => 'required|exists:address_t,id',
        ]);

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }else{
            $user = auth()->user();

            $candidate                         = new Candidate();
            $candidate->id                     = Str::uuid();
            $candidate->owner_id               = $user->id;
            $candidate->first_name             = $request->first_name;
            $candidate->last_name              = $request->last_name;
            $candidate->age                    = $request->age;
            $candidate->department             = $request->department;
            $candidate->min_salary_expectation = $request->min_salary_expectation;
            $candidate->max_salary_expectation = $request->max_salary_expectation;

            $candidate->currency_id            = $request->currency_id;
            $candidate->address_id             = $request->address_id;
            
            $candidate->save();

            return response()->json([
                'success' => true,
                'message' => 'Candidate Saved Successfully'
            ], 200);
        }
    }

    /**
 * @OA\Get(
 *     path="/v1/candidates/{id}",
 *     summary="Get a specific candidate",
 *     operationId="getCandidate",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the candidate",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful response"
 *     ),
 *     @OA\Header(
 *         header="Authorization",
 *         description="Bearer {access_token}",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     )
 * )
 */


     /**
 * @OA\Get(
 *     path="/v1/candidates",
 *     summary="Get all candidates with pagination",
 *     operationId="getAllCandidates",
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         required=false,
 *         description="Page number",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         required=false,
 *         description="Number of items per page",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful response"
 *     ),
 *     @OA\Header(
 *         header="Authorization",
 *         description="Bearer {access_token}",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     )
 * )
 */

    function show($id = null){
        $user = auth()->user();

        if($id){
            $candidates = Candidate::select('candidate_t.*', 'currency_t.code AS currency', 'address_t.country', 'address_t.street_address', 'address_t.city', 'address_t.state', 'address_t.postal_code')
            ->join('currency_t', 'candidate_t.currency_id', '=', 'currency_t.id')
            ->join('address_t', 'candidate_t.address_id', '=', 'address_t.id')
            ->where('candidate_t.owner_id', $user->id)
            ->where('candidate_t.id', $id)
            ->first();
        }else{
            $perPage    = 10;

            $candidates = Candidate::select('candidate_t.*', 'currency_t.code AS currency', 'address_t.country', 'address_t.street_address', 'address_t.city', 'address_t.state', 'address_t.postal_code')
            ->where('owner_id', $user->id)
            ->join('currency_t', 'candidate_t.currency_id', '=', 'currency_t.id')
            ->join('address_t', 'candidate_t.address_id', '=', 'address_t.id')
            ->paginate($perPage);
        }

        return response()->json(['candidates' => $candidates]);
    }

    
    /**
 * @OA\Post(
 *     path="/v1/candidates/search",
 *     summary="Search for candidates with pagination",
 *     operationId="searchCandidates",
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="keyword", type="string"),
 *             @OA\Property(property="department", type="string"),
 *             @OA\Property(property="min_salary", type="number"),
 *             @OA\Property(property="max_salary", type="number"),
 *         ),
 *     ),
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         required=false,
 *         description="Page number",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         required=false,
 *         description="Number of items per page",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful response"
 *     ),
 *     @OA\Header(
 *         header="Authorization",
 *         description="Bearer {access_token}",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     )
 * )
 */

    public function search(Request $request){
        $query = Candidate::query();

        // Add search conditions based on request parameters
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', '%' . $keyword . '%')
                    ->orWhere('last_name', 'like', '%' . $keyword . '%')
                    ->orWhere('department', 'like', '%' . $keyword . '%');
            });
        }

        // Add search conditions for related tables
        if ($request->has('country')) {
            $country = $request->input('country');
            $query->whereHas('address', function ($q) use ($country) {
                $q->where('country', 'like', '%' . $country . '%');
            });
        }

        // Add more conditions based on your search criteria

        $candidates = $query->paginate(10);

        return response()->json($candidates);
    }

    
    /**
 * @OA\Delete(
 *     path="/v1/candidates/{id}",
 *     summary="Delete a specific candidate",
 *     operationId="deleteCandidate",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the candidate to delete",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful response"
 *     ),
 *     @OA\Header(
 *         header="Authorization",
 *         description="Bearer {access_token}",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     )
 * )
 */

    public function delete($id)
    {
        $candidate = Candidate::find($id);

        if (!$candidate) {
            return response()->json(['message' => 'Candidate not found'], 404);
        }

        $candidate->delete();

        return response()->json(['message' => 'Candidate deleted']);
    }

    /**
 * @OA\Post(
 *     path="/v1/candidates/{id}",
 *     summary="Update a candidate",
 *     operationId="updateCandidate",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID of the candidate to update",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="first_name", type="string"),
 *             @OA\Property(property="last_name", type="string"),
 *             @OA\Property(property="age", type="integer"),
 *             @OA\Property(property="department", type="string"),
 *             @OA\Property(property="min_salary_expectation", type="number"),
 *             @OA\Property(property="max_salary_expectation", type="number"),
 *             @OA\Property(property="currency_id", type="string"),
 *             @OA\Property(property="address_id", type="string"),
 *             @OA\Property(property="phone_numbers", type="array", @OA\Items(type="object")),
 *             @OA\Property(property="educations", type="array", @OA\Items(type="object")),
 *             @OA\Property(property="skills", type="array", @OA\Items(type="object")),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful response"
 *     ),
 *     @OA\Header(
 *         header="Authorization",
 *         description="Bearer {access_token}",
 *         @OA\Schema(
 *             type="string"
 *         )
 *     )
 * )
 */

    public function update(Request $request, $id)
    {
        $candidate = Candidate::findOrFail($id);

        // Update candidate's basic information
        $candidate_data = [];

        if ($request->has('first_name')) {
            $candidate_data['first_name'] = $request->input('first_name');
        }

        if ($request->has('last_name')) {
            $candidate_data['last_name'] = $request->input('last_name');
        }

        if ($request->has('age')) {
            $candidate_data['age'] = $request->input('age');
        }

        if ($request->has('department')) {
            $candidate_data['department'] = $request->input('department');
        }

        if ($request->has('min_salary_expectation')) {
            $candidate_data['min_salary_expectation'] = $request->input('min_salary_expectation');
        }

        if ($request->has('max_salary_expectation')) {
            $candidate_data['max_salary_expectation'] = $request->input('max_salary_expectation');
        }

        $candidate->update($candidate_data);

        // Update or add skills
        if($request->has('skills')){
            $skills = json_decode($request->input('skills'), true);

            foreach ($skills as $skillData) {
                $skill = new Skill();
                $skill->id = Str::uuid();
                $skill->candidate_id = $candidate->id;
                $skill->skill = $skillData['skill'];
                $skill->level = $skillData['level'];

                $skill->save();
            }
        }

        // Update or add phone numbers
        if($request->has('phone_numbers')){
            $phone_numbers = json_decode($request->input('phone_numbers'), true);

            foreach ($phone_numbers as $phoneNumberData) {
                $phone = new Phone();
                $phone->id = Str::uuid();
                $phone->candidate_id = $candidate->id;
                $phone->type = $phoneNumberData['type'];
                $phone->number = $phoneNumberData['number'];

                $phone->save();
            }
        }

        // Update or add education
        if($request->has('education')){
            $education = json_decode($request->input('education'), true);

            foreach ($education as $educationData) {
                $edc = new Education();
                $edc->id = Str::uuid();
                $edc->candidate_id = $candidate->id;
                $edc->school = $educationData['school'];
                $edc->degree = $educationData['degree'];
                $edc->major = $educationData['major'];

                $edc->save();
            }
        }

        // Update or add experiences
        if($request->has('experiences')){
            $experience = json_decode($request->input('experiences'), true);

            foreach ($experience as $experienceData) {
                $exp = new Experience();
                $exp->id = Str::uuid();
                $exp->candidate_id = $candidate->id;
                $exp->company = $experienceData['company'];
                $exp->title = $experienceData['title'];
                $exp->years = $experienceData['years'];

                $exp->save();
            }
        }

        return response()->json(['message' => 'Candidate updated successfully']);
    }
}

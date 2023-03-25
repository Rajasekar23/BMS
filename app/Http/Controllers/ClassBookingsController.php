<?php

namespace App\Http\Controllers;

use Exception;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\ClassBookingRepository;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\ClassBookingCreateRequest;
use App\Http\Requests\ClassBookingUpdateRequest;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;



/**
 * Class ClassBookingsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ClassBookingsController extends Controller
{
    /**
     * @var ClassBookingRepository
     */
    protected $repository;



    /**
     * ClassBookingsController constructor.
     *
     * @param ClassBookingRepository $repository
     */
    public function __construct(ClassBookingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $classBookings = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $classBookings,
            ]);
        }

        return view('classBookings.index', compact('classBookings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ClassBookingCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ClassBookingCreateRequest $request)
    {
        try {

            $classBooking = $this->repository->create($request->all());

            $response = [
                'message' => 'ClassBooking created.',
                'data'    => $classBooking->toArray(),
            ];

            return response()->json($response);
        }
        catch (ValidationException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->errors()
            ]);
        }
        catch (ValidatorException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->toArray()
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $classBooking = $this->repository->find($id);

        return response()->json([
            'data' => $classBooking,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $classBooking = $this->repository->find($id);

        return view('classBookings.edit', compact('classBooking'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ClassBookingUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ClassBookingUpdateRequest $request, $id)
    {
        try {


            $classBooking = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ClassBooking updated.',
                'data'    => $classBooking->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        return response()->json([
            'message' => 'ClassBooking deleted.',
            'deleted' => $deleted,
        ]);
    }

    public function getAvailableSlots()
    {
        $slots = $this->repository->getAvailableSlots();

        return response()->json([
            'data' => $slots,
        ]);
    }

    public function cancelSlot(Request $request, $bookingId)
    {

        try {
            $response = $this->repository->cancelSlot($bookingId);
            return response()->json($response);
        }
        catch (ValidationException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->errors()
            ]);
        }
        catch (ValidatorException $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->toArray()
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ]);
        }

    }






}

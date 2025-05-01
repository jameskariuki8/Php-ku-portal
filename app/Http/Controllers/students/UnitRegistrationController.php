<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\StudentCourseEnrollment;
use App\Models\Unit;
use App\Models\StudentUnitRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitRegistrationController extends Controller
{
    // Constants for status messages
    const UNIT_REGISTERED_SUCCESS = 'Successfully registered for unit!';
    const UNIT_DROPPED_SUCCESS = 'Unit successfully dropped';
    const ENROLLMENT_REQUIRED = 'You must enroll in a course first.';
    const UNIT_NOT_IN_COURSE = 'This unit does not belong to your enrolled course.';
    const ALREADY_REGISTERED = 'You are already registered for this unit.';
    const DROP_PERIOD_EXPIRED = 'You can only drop units within 7 days of registration';

    /**
     * Display unit registration page
     */
    public function index()
    {
        $user = Auth::user();
        $enrollment = $user->enrollment()->with(['course', 'registeredUnits'])->first();
        
        if (!$enrollment) {
            return redirect()->route('student.enroll')
                ->with('error', self::ENROLLMENT_REQUIRED);
        }
        
        $registeredUnitIds = $enrollment->registeredUnits->pluck('id');
        
        $availableUnits = Unit::where('course_id', $enrollment->course_id)
            ->whereNotIn('id', $registeredUnitIds)
            ->get();
            
        return view('student.units.index', [
            'enrollment' => $enrollment,
            'availableUnits' => $availableUnits,
            'registeredUnits' => $enrollment->registeredUnits
        ]);
    }

    /**
     * Register for a new unit
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $enrollment = $user->enrollment;
        
        if (!$enrollment) {
            return redirect()->route('student.enroll')
                ->with('error', self::ENROLLMENT_REQUIRED);
        }
        
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
        ]);
        
        $unit = Unit::findOrFail($validated['unit_id']);
        
        $this->validateUnitRegistration($enrollment, $unit);
        
        $this->registerUnit($enrollment, $unit);
        
        return redirect()->route('student.units.index')
            ->with('success', self::UNIT_REGISTERED_SUCCESS);
    }

    /**
     * Drop a registered unit
     */
    public function destroy($unitId)
    {
        $user = Auth::user();
        $enrollment = $user->enrollment;
        
        if (!$enrollment) {
            abort(404, self::ENROLLMENT_REQUIRED);
        }
        
        $registration = $enrollment->unitRegistrations()
            ->where('unit_id', $unitId)
            ->firstOrFail();
        
        $this->authorize('delete', $registration);
        
        $this->validateDropPeriod($registration);
        
        $this->dropUnit($registration);
        
        return redirect()->route('student.units.index')
            ->with('success', self::UNIT_DROPPED_SUCCESS);
    }

    /**
     * Validate unit registration requirements
     */
    protected function validateUnitRegistration($enrollment, $unit)
    {
        if ($unit->course_id != $enrollment->course_id) {
            abort(422, self::UNIT_NOT_IN_COURSE);
        }
        
        if ($enrollment->registeredUnits()->where('unit_id', $unit->id)->exists()) {
            abort(422, self::ALREADY_REGISTERED);
        }
    }

    /**
     * Register a unit for student
     */
    protected function registerUnit($enrollment, $unit)
    {
        $enrollment->registeredUnits()->attach($unit->id, [
            'registration_date' => now(),
            'status' => 'registered'
        ]);
    }

    /**
     * Validate unit drop period
     */
    protected function validateDropPeriod($registration)
    {
        if ($registration->created_at->diffInDays(now()) > 7) {
            abort(403, self::DROP_PERIOD_EXPIRED);
        }
    }

    /**
     * Process unit drop
     */
    protected function dropUnit($registration)
    {
        $registration->delete();
    }
}
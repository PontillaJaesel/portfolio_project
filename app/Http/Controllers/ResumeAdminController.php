<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Project;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ResumeAdminController extends Controller
{
    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('skills', 'experience', 'projects', 'education', 'organizations');
        return view('admin.edit_resume', ['user_info' => $user]);
    }

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
        ]);

        $user->update($validated);
        
        return back()->with('success_message', 'Profile updated successfully!')
                     ->with('section_to_show', ''); // Tells JS to stay on the main section
    }

    public function addSkill(Request $request)
    {
        $validated = $request->validate(['skill' => 'required|string|max:255']);
        $request->user()->skills()->create($validated);
        return back()->with('success_message', 'Skill added!')
                     ->with('section_to_show', 'skills-section');
    }

    public function deleteSkill(Skill $skill)
    {
        $skill->delete();
        return back()->with('success_message', 'Skill deleted!')
                     ->with('section_to_show', 'skills-section');
    }

    public function addEducation(Request $request)
    {
        $validated = $request->validate([
            'degree' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'year_range' => 'required|string|max:255',
            'courses' => 'nullable|string|max:255',
        ]);
        $request->user()->education()->create($validated);
        return back()->with('success_message', 'Education added!')
                     ->with('section_to_show', 'education-section');
    }

    public function deleteEducation(Education $education)
    {
        $education->delete();
        return back()->with('success_message', 'Education entry deleted!')
                     ->with('section_to_show', 'education-section');
    }

    public function addExperience(Request $request)
    {
        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'year_range' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);
        $request->user()->experience()->create($validated);
        return back()->with('success_message', 'Experience added!')
                     ->with('section_to_show', 'experience-section');
    }

    public function deleteExperience(Experience $experience)
    {
        $experience->delete();
        return back()->with('success_message', 'Experience entry deleted!')
                     ->with('section_to_show', 'experience-section');
    }

    public function addProject(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'organization' => 'nullable|string|max:255',
            'year' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);
        $request->user()->projects()->create($validated);
        return back()->with('success_message', 'Project added!')
                     ->with('section_to_show', 'projects-section');
    }

    public function deleteProject(Project $project)
    {
        $project->delete();
        return back()->with('success_message', 'Project entry deleted!')
                     ->with('section_to_show', 'projects-section');
    }

    public function addOrganization(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'year_range' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        try {
            DB::transaction(function () use ($request, $validated) {
                $organization = $request->user()->organizations()->create(['name' => $validated['name']]);
                $organization->positions()->create([
                    'role' => $validated['role'],
                    'year_range' => $validated['year_range'],
                    'details' => $validated['details'],
                ]);
            });
        } catch (\Exception $e) {
            return back()->withErrors(['db_error' => 'Could not save organization: ' . $e->getMessage()])
                         ->with('section_to_show', 'organizations-section');
        }

        return back()->with('success_message', 'Organization added!')
                     ->with('section_to_show', 'organizations-section');
    }

    public function deleteOrganization(Organization $organization)
    {
        $organization->delete();
        return back()->with('success_message', 'Organization deleted!')
                     ->with('section_to_show', 'organizations-section');
    }
}
@extends('layouts.main')
@section('title', 'Edit My Resume')
@section('body-class', 'flex justify-center items-center flex-col p-5')

@section('content')
<div class="w-full flex justify-center items-center min-h-[1300px] min-w-[1500px] rounded-xl bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-purple-700 via-purple-900 to-black">
    <div class="w-full max-w-[1200px] min-h-[850px] my-10 mx-auto p-8 bg-transparent rounded-md shadow-xl text-zinc-800 flex flex-col">

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong>Please fix the following errors:</strong>
                <ul class="list-disc list-inside ml-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success_message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                <p>{{ session('success_message') }}</p>
            </div>
        @endif

        {{--  Main two-column layout --}}
        <div class="flex flex-col lg:flex-row gap-8 flex-1 lg:items-stretch overflow-hidden">

            {{--  Left panel: Personal info --}}
            <div class="lg:w-[420px] lg:flex-shrink-0 p-6 bg-purple-200 border border-purple-200 rounded-md min-h-[750px]">
                <div class="edit-section">
                    <h2 class="text-2xl font-semibold mb-4 border-b pb-2">Edit Personal Information</h2>
                    <form method="POST" action="{{ route('admin.profile.update') }}" id="profile-form" class="space-y-4">
                        @csrf
                        @php
                            $inputClasses = "w-full p-2 border border-gray-300 rounded-md";
                            $labelClasses = "block font-medium mb-1";
                        @endphp
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="form-group flex-1">
                                <label for="name" class="{{ $labelClasses }}">Full Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user_info->name) }}" class="{{ $inputClasses }}">
                            </div>
                            <div class="form-group flex-1">
                                <label for="title" class="{{ $labelClasses }}">Title</label>
                                <input type="text" id="title" name="title" value="{{ old('title', $user_info->title) }}" class="{{ $inputClasses }}">
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="form-group flex-1">
                                <label for="email" class="{{ $labelClasses }}">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user_info->email) }}" class="{{ $inputClasses }}">
                            </div>
                            <div class="form-group flex-1">
                                <label for="phone" class="{{ $labelClasses }}">Phone</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $user_info->phone) }}" class="{{ $inputClasses }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address" class="{{ $labelClasses }}">Address</label>
                            <input type="text" id="address" name="address" value="{{ old('address', $user_info->address) }}" class="{{ $inputClasses }}">
                        </div>
                        <div class="form-group">
                            <label for="summary" class="{{ $labelClasses }}">Profile Summary</label>
                            <textarea id="summary" name="summary" class="{{ $inputClasses }} h-80">{{ old('summary', $user_info->summary) }}</textarea>
                        </div>
                        <div class="form-buttons mt-6">
                            <button type="submit" class="w-full p-3 bg-indigo-800 text-white rounded-md font-semibold hover:bg-indigo-950 transition-colors">Save Personal Info</button>
                        </div>
                    </form>
                </div>
            </div>

            {{--  Right panel: Switchable sections --}}
            <div class="flex-1 min-w-0 p-6 bg-purple-200 border border-purple-200 rounded-md flex flex-col h-[750px] overflow-hidden relative">
                <div class="form-group">
                    <label for="section-switcher" class="block font-medium mb-1">Choose a section to edit:</label>
                    <select id="section-switcher" onchange="showEditSection(this.value)" class="w-full p-2 border border-gray-300 rounded-md">
                        <option value="">-- Select a Section --</option>
                        <option value="skills-section">Edit Skills</option>
                        <option value="education-section">Edit Education</option>
                        <option value="experience-section">Edit Experience</option>
                        <option value="projects-section">Edit Projects</option>
                        <option value="organizations-section">Edit Organizations</option>
                    </select>
                </div>

                @php
                    $sectionClass = "edit-section switchable-section hidden min-h-[600px]";
                    $addFormClass = "add-form p-4 bg-gray-100 rounded-md mt-6 space-y-3";
                    $addBtn = "add-btn py-2 px-4 bg-green-800 text-white rounded-md hover:bg-green-900 transition-colors";
                    $deleteBtn = "delete-btn py-1 px-3 bg-rose-800 text-white rounded-md hover:bg-red-900 transition-colors text-sm";
                    $listClass = "item-list space-y-2";
                    $listItem = "flex justify-between items-center p-3 bg-gray-50 border rounded-md";
                    $input = "w-full p-2 border border-gray-300 rounded-md";
                    $label = "block font-medium mb-1 text-sm";
                    $formRow = "flex flex-col sm:flex-row gap-4";
                @endphp

                <div class="pr-2 mt-6 border-t pt-6 flex-1 overflow-y-auto h-[650px]">

                    {{--  Skills --}}
                    <div class="{{ $sectionClass }}" id="skills-section">
                        <h2 class="text-2xl font-semibold mb-4">Edit Skills</h2>
                        <ul class="{{ $listClass }}">
                            @forelse ($user_info->skills as $skill)
                                <li class="{{ $listItem }}">
                                    <span>{{ $skill->skill }}</span>
                                    <form method="POST" action="{{ route('skills.delete', $skill) }}" onsubmit="return confirm('Are you sure?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="{{ $deleteBtn }}">Delete</button>
                                    </form>
                                </li>
                            @empty
                                <li>No skills added yet.</li>
                            @endforelse
                        </ul>
                        <form method="POST" action="{{ route('skills.add') }}" class="{{ $addFormClass }}">
                            @csrf
                            <h3 class="text-lg font-semibold">Add New Skill</h3>
                            <div class="form-group">
                                <label for="skill" class="{{ $label }}">Skill (e.g., "Programming: Python, PHP")</label>
                                <input type="text" id="skill" name="skill" placeholder="Enter new skill" value="{{ old('skill') }}" class="{{ $input }}">
                            </div>
                            <button type="submit" class="{{ $addBtn }}">Add Skill</button>
                        </form>
                    </div>

                    {{--  Education --}}
                    <div class="{{ $sectionClass }}" id="education-section">
                        <h2 class="text-2xl font-semibold mb-4">Edit Education</h2>
                        <ul class="{{ $listClass }}">
                            @forelse ($user_info->education as $edu)
                                <li class="{{ $listItem }}">
                                    <div>
                                        <strong>{{ $edu->degree }}</strong><br>
                                        <small class="text-gray-600">{{ $edu->school }} ({{ $edu->year_range }})</small>
                                    </div>
                                    <form method="POST" action="{{ route('education.delete', $edu) }}" onsubmit="return confirm('Are you sure?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="{{ $deleteBtn }}">Delete</button>
                                    </form>
                                </li>
                            @empty
                                <li>No education entries added yet.</li>
                            @endforelse
                        </ul>
                        <form method="POST" action="{{ route('education.add') }}" class="{{ $addFormClass }}">
                            @csrf
                            <h3 class="text-lg font-semibold">Add New Education</h3>
                            <div class="{{ $formRow }}">
                                <div class="form-group flex-1">
                                    <label for="degree" class="{{ $label }}">Degree</label>
                                    <input type="text" id="degree" name="degree" placeholder="e.g., BS in Computer Science" value="{{ old('degree') }}" class="{{ $input }}">
                                </div>
                                <div class="form-group flex-1">
                                    <label for="school" class="{{ $label }}">School</label>
                                    <input type="text" id="school" name="school" placeholder="e.g., Your University" value="{{ old('school') }}" class="{{ $input }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="year_range" class="{{ $label }}">Year Range</label>
                                <input type="text" id="year_range" name="year_range" placeholder="e.g., 2022 - 2026" value="{{ old('year_range') }}" class="{{ $input }}">
                            </div>
                            <div class="form-group">
                                <label for="courses" class="{{ $label }}">Relevant Courses (Optional)</label>
                                <input type="text" id="courses" name="courses" placeholder="e.g., Data Structures, HCI" value="{{ old('courses') }}" class="{{ $input }}">
                            </div>
                            <button type="submit" class="{{ $addBtn }}">Add Education</button>
                        </form>
                    </div>
                    
                    {{--  Experience --}}
                    <div class="{{ $sectionClass }}" id="experience-section">
                        <h2 class="text-2xl font-semibold mb-4">Edit Experience</h2>
                        <ul class="{{ $listClass }}">
                            @forelse ($user_info->experience as $exp)
                                <li class="{{ $listItem }}">
                                    <div>
                                        <strong>{{ $exp->position }}</strong><br>
                                        <small class="text-gray-600">{{ $exp->company }} ({{ $exp->year_range }})</small>
                                    </div>
                                    <form method="POST" action="{{ route('experience.delete', $exp) }}" onsubmit="return confirm('Are you sure?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="{{ $deleteBtn }}">Delete</button>
                                    </form>
                                </li>
                            @empty
                                <li>No experience entries added yet.</li>
                            @endforelse
                        </ul>
                        <form method="POST" action="{{ route('experience.add') }}" class="{{ $addFormClass }}">
                            @csrf
                            <h3 class="text-lg font-semibold">Add New Experience</h3>
                            <div class="{{ $formRow }}">
                                <div class="form-group flex-1">
                                    <label for="position" class="{{ $label }}">Position</label>
                                    <input type="text" id="position" name="position" placeholder="e.g., Web Developer Intern" value="{{ old('position') }}" class="{{ $input }}">
                                </div>
                                <div class="form-group flex-1">
                                    <label for="company" class="{{ $label }}">Company</label>
                                    <input type="text" id="company" name="company" placeholder="e.g., Tech Corp" value="{{ old('company') }}" class="{{ $input }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="year_range_exp" class="{{ $label }}">Year Range</label>
                                <input type="text" id="year_range_exp" name="year_range" placeholder="e.g., June 2024 - Aug 2024" value="{{ old('year_range') }}" class="{{ $input }}">
                            </div>
                            <div class="form-group">
                                <label for="details_exp" class="{{ $label }}">Details (Optional)</label>
                                <textarea id="details_exp" name="details" placeholder="e.g., Developed and maintained web pages..." class="{{ $input }} h-24">{{ old('details') }}</textarea>
                            </div>
                            <button type="submit" class="{{ $addBtn }}">Add Experience</button>
                        </form>
                    </div>
                    
                    {{--  Projects --}}
                    <div class="{{ $sectionClass }}" id="projects-section">
                        <h2 class="text-2xl font-semibold mb-4">Edit Projects</h2>
                        <ul class="{{ $listClass }}">
                            @forelse ($user_info->projects as $proj)
                                <li class="{{ $listItem }}">
                                    <div>
                                        <strong>{{ $proj->title }}</strong><br>
                                        <small class="text-gray-600">{{ $proj->organization }} ({{ $proj->year }})</small>
                                    </div>
                                    <form method="POST" action="{{ route('projects.delete', $proj) }}" onsubmit="return confirm('Are you sure?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="{{ $deleteBtn }}">Delete</button>
                                    </form>
                                </li>
                            @empty
                                <li>No projects added yet.</li>
                            @endforelse
                        </ul>
                        <form method="POST" action="{{ route('projects.add') }}" class="{{ $addFormClass }}">
                            @csrf
                            <h3 class="text-lg font-semibold">Add New Project</h3>
                            <div class="{{ $formRow }}">
                                <div class="form-group flex-1">
                                    <label for="title_proj" class="{{ $label }}">Project Title</label>
                                    <input type="text" id="title_proj" name="title" placeholder="e.g., Portfolio Website" value="{{ old('title') }}" class="{{ $input }}">
                                </div>
                                <div class="form-group">
                                    <label for="year_proj" class="{{ $label }}">Year</label>
                                    <input type="text" id="year_proj" name="year" placeholder="e.g., 2024" value="{{ old('year') }}" class="{{ $input }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="organization_proj" class="{{ $label }}">Organization (Optional)</label>
                                <input type="text" id="organization_proj" name="organization" placeholder="e.g., Personal Project" value="{{ old('organization') }}" class="{{ $input }}">
                            </div>
                            <div class="form-group">
                                <label for="details_proj" class="{{ $label }}">Details (Optional)</label>
                                <textarea id="details_proj" name="details" placeholder="e.g., Built with PHP and PostgreSQL..." class="{{ $input }} h-24">{{ old('details') }}</textarea>
                            </div>
                            <button type="submit" class="{{ $addBtn }}">Add Project</button>
                        </form>
                    </div>

                    {{--  Organizations --}}
                    <div class="{{ $sectionClass }}" id="organizations-section">
                        <h2 class="text-2xl font-semibold mb-4">Edit Organizations</h2>
                        <p class="text-sm text-gray-600 mb-4">Note: Deleting an organization also deletes all its positions.</p>
                        <ul class="{{ $listClass }}">
                            @forelse ($user_info->organizations as $org)
                                <li class="{{ $listItem }}">
                                    <div>
                                        <strong>{{ $org->name }}</strong><br>
                                        <small class="text-gray-600">This entry contains one or more positions.</small>
                                    </div>
                                    <form method="POST" action="{{ route('organizations.delete', $org) }}" onsubmit="return confirm('Are you sure? This will delete the organization and ALL its positions.');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="{{ $deleteBtn }}">Delete</button>
                                    </form>
                                </li>
                            @empty
                                <li>No organizations added yet.</li>
                            @endforelse
                        </ul>
                        <form method="POST" action="{{ route('organizations.add') }}" class="{{ $addFormClass }}">
                            @csrf
                            <h3 class="text-lg font-semibold">Add New Organization & First Position</h3>
                            <div class="form-group">
                                <label for="name_org" class="{{ $label }}">Organization Name</label>
                                <input type="text" id="name_org" name="name" placeholder="e.g., Computer Science Society" value="{{ old('name') }}" class="{{ $input }}">
                            </div>
                            <div class="{{ $formRow }}">
                                <div class="form-group flex-1">
                                    <label for="role_org" class="{{ $label }}">Your Role</label>
                                    <input type="text" id="role_org" name="role" placeholder="e.g., President" value="{{ old('role') }}" class="{{ $input }}">
                                </div>
                                <div class="form-group">
                                    <label for="year_range_org" class="{{ $label }}">Year Range</label>
                                    <input type="text" id="year_range_org" name="year_range" placeholder="e.g., 2024 - 2025" value="{{ old('year_range') }}" class="{{ $input }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="details_org" class="{{ $label }}">Details (Optional)</label>
                                <textarea id="details_org" name="details" placeholder="e.g., Led weekly meetings..." class="{{ $input }} h-24">{{ old('details') }}</textarea>
                            </div>
                            <button type="submit" class="{{ $addBtn }}">Add Organization</button>
                        </form>
                    </div>
                </div>
                </div>
        </div>

        {{--  Buttons  --}}
        <div class="global-nav-buttons mt-8 border-gray-200 text-center flex justify-center gap-4">
            <a href="{{ route('resume.public', ['user' => Auth::id()]) }}" target="_blank" 
            class="inline-block py-2 px-6 rounded-md bg-gray-600 text-white font-semibold transition hover:bg-gray-700">
                View Public Portfolio
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <a href="{{ route('logout') }}" 
                class="inline-block py-2 px-6 rounded-md bg-gray-400 text-black font-semibold transition hover:bg-gray-500"
                onclick="event.preventDefault(); this.closest('form').submit();">
                    Logout
                </a>
            </form>
        </div>
    </div>
</div>

{{-- Section data for restoring which section to show --}}
<div id="section-data-container" data-section-to-show="{{ session('section_to_show', '') }}"></div>

<script>
    function showEditSection(sectionId) {
        // hide all
        document.querySelectorAll('.switchable-section').forEach(s => s.classList.add('hidden'));
        // show target
        if (sectionId) {
            const t = document.getElementById(sectionId);
            if (t) t.classList.remove('hidden');
            const sel = document.getElementById('section-switcher');
            if (sel) sel.value = sectionId;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const sectionToShow = document.getElementById('section-data-container').dataset.sectionToShow;
        if (sectionToShow) showEditSection(sectionToShow);
    });
</script>
@endsection

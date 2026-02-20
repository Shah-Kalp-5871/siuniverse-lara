<!-- Onboarding Modal -->
<div id="onboardingModal" class="fixed inset-0 bg-black/50 z-[60] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-primary to-accent rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-plus text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Welcome to SIU UNIVERSE</h3>
                            <p class="text-sm text-gray-600">Complete your profile to join communities</p>
                        </div>
                    </div>
                    <button onclick="closeOnboardingModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            
            <!-- Onboarding Steps -->
            <div class="p-6">
                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Profile Setup</span>
                        <span id="stepIndicator" class="text-sm font-medium text-primary">Step 1 of 4</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="progressBar" class="bg-primary h-2 rounded-full w-1/4"></div>
                    </div>
                </div>
                
                <!-- Step 1: Basic Info -->
                <div id="step1" class="step-content">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Basic Information</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Full Name</label>
                            <input 
                                type="text" 
                                id="userName"
                                placeholder="Enter your full name"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            >
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Accommodation Type</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3" id="accommodationOptions">
                                <label class="relative">
                                    <input type="radio" name="accommodation" value="hostel" class="sr-only peer">
                                    <div class="p-4 border-2 border-gray-200 rounded-lg text-center cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-primary/5">
                                        <i class="fas fa-building text-2xl text-gray-400 mb-2"></i>
                                        <div class="font-medium text-gray-700">Hostel</div>
                                        <div class="text-sm text-gray-500">Living in college hostel</div>
                                    </div>
                                </label>
                                
                                <label class="relative">
                                    <input type="radio" name="accommodation" value="pg" class="sr-only peer">
                                    <div class="p-4 border-2 border-gray-200 rounded-lg text-center cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-primary/5">
                                        <i class="fas fa-home text-2xl text-gray-400 mb-2"></i>
                                        <div class="font-medium text-gray-700">PG / Flat</div>
                                        <div class="text-sm text-gray-500">Private accommodation</div>
                                    </div>
                                </label>
                                
                                <label class="relative">
                                    <input type="radio" name="accommodation" value="day_scholar" class="sr-only peer">
                                    <div class="p-4 border-2 border-gray-200 rounded-lg text-center cursor-pointer hover:border-primary peer-checked:border-primary peer-checked:bg-primary/5">
                                        <i class="fas fa-user text-2xl text-gray-400 mb-2"></i>
                                        <div class="font-medium text-gray-700">Day Scholar</div>
                                        <div class="text-sm text-gray-500">Commuting from home</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-8">
                        <button onclick="nextStep(2)" class="bg-primary text-white px-8 py-3 rounded-lg hover:bg-secondary transition-colors font-semibold">
                            Next <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 2: Hostel Details (Conditional) -->
                <div id="step2" class="step-content hidden">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Hostel Details</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Select Hostel</label>
                            <select id="hostelSelect" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">-- Select Hostel --</option>
                                <option value="viola">Viola Hostel</option>
                                <option value="sit">SIT Hostel</option>
                                <option value="petunia">Petunia Hostel</option>
                                <option value="hilltop">Hilltop Hostel</option>
                                <option value="medical">Medical Hostel</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Room Number</label>
                            <input 
                                type="text" 
                                placeholder="e.g., A-101"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            >
                        </div>
                    </div>
                    
                    <div class="flex justify-between mt-8">
                        <button onclick="prevStep(1)" class="text-gray-600 hover:text-gray-800 font-medium">
                            <i class="fas fa-arrow-left mr-2"></i>Back
                        </button>
                        <button onclick="nextStep(3)" class="bg-primary text-white px-8 py-3 rounded-lg hover:bg-secondary transition-colors font-semibold">
                            Next <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 2: PG Details (Conditional) -->
                <div id="step2-pg" class="step-content hidden">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">PG / Flat Details</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">PG/Flat Name</label>
                            <input 
                                type="text" 
                                placeholder="e.g., Sunshine PG, ABC Apartments"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                            >
                        </div>
                    </div>
                    
                    <div class="flex justify-between mt-8">
                        <button onclick="prevStep(1)" class="text-gray-600 hover:text-gray-800 font-medium">
                            <i class="fas fa-arrow-left mr-2"></i>Back
                        </button>
                        <button onclick="nextStep(3)" class="bg-primary text-white px-8 py-3 rounded-lg hover:bg-secondary transition-colors font-semibold">
                            Next <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 2: Day Scholar Details (Conditional) -->
                <div id="step2-day" class="step-content hidden">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Day Scholar Details</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Commute Method</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">-- Select Primary Transport --</option>
                                <option value="college_bus">College Bus</option>
                                <option value="personal_vehicle">Personal Vehicle</option>
                                <option value="public_transport">Public Transport</option>
                                <option value="walk">Walking/Cycling</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-between mt-8">
                        <button onclick="prevStep(1)" class="text-gray-600 hover:text-gray-800 font-medium">
                            <i class="fas fa-arrow-left mr-2"></i>Back
                        </button>
                        <button onclick="nextStep(3)" class="bg-primary text-white px-8 py-3 rounded-lg hover:bg-secondary transition-colors font-semibold">
                            Next <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 3: Institute & Course -->
                <div id="step3" class="step-content hidden">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Academic Details</h4>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Institute</label>
                            <select id="instituteSelect" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">-- Select Institute --</option>
                                <option value="saii">SAII</option>
                                <option value="simc">SIMC</option>
                                <option value="sibm">SIBM</option>
                                <option value="sidtm">SIDTM</option>
                                <option value="sit">SIT</option>
                                <option value="ssbf">SSBF</option>
                                <option value="ssvap">SSVAP</option>
                                <option value="sscans">SSCANS</option>
                                <option value="scon">SCON</option>
                                <option value="schs">SCHS</option>
                                <option value="ssss">SSSS</option>
                                <option value="sihs">SIHS</option>
                                <option value="smcw">SMCW</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-between mt-8">
                        <button onclick="prevStep(2)" class="text-gray-600 hover:text-gray-800 font-medium">
                            <i class="fas fa-arrow-left mr-2"></i>Back
                        </button>
                        <button onclick="nextStep(4)" class="bg-primary text-white px-8 py-3 rounded-lg hover:bg-secondary transition-colors font-semibold">
                            Next <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Step 4: Review & Complete -->
                <div id="step4" class="step-content hidden">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Review Your Profile</h4>
                    <div class="bg-gray-50 rounded-xl p-6 mb-6">
                        <p class="text-sm text-gray-600">Review your information before completing onboarding.</p>
                    </div>
                    
                    <div class="flex justify-between mt-8">
                        <button onclick="prevStep(3)" class="text-gray-600 hover:text-gray-800 font-medium">
                            <i class="fas fa-arrow-left mr-2"></i>Back
                        </button>
                        <button onclick="completeOnboarding()" class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-lg transition-colors font-semibold">
                            <i class="fas fa-check mr-2"></i>Complete Onboarding
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentOnboardingStep = 1;
    let onboardingAccommodation = '';
    
    function showOnboardingStep(step) {
        document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
        document.getElementById(`step${step}`).classList.remove('hidden');
        
        const progress = (step / 4) * 100;
        document.getElementById('progressBar').style.width = `${progress}%`;
        document.getElementById('stepIndicator').textContent = `Step ${step} of 4`;
        currentOnboardingStep = step;
    }
    
    function nextStep(step) {
        if (step === 2) {
            const accommodation = document.querySelector('input[name="accommodation"]:checked');
            if (!accommodation) {
                Swal.fire('Incomplete', 'Please select your accommodation type', 'warning');
                return;
            }
            onboardingAccommodation = accommodation.value;
            
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
            if (onboardingAccommodation === 'hostel') document.getElementById('step2').classList.remove('hidden');
            else if (onboardingAccommodation === 'pg') document.getElementById('step2-pg').classList.remove('hidden');
            else if (onboardingAccommodation === 'day_scholar') document.getElementById('step2-day').classList.remove('hidden');
            
            document.getElementById('progressBar').style.width = '50%';
            document.getElementById('stepIndicator').textContent = 'Step 2 of 4';
            currentOnboardingStep = 2;
            return;
        }
        showOnboardingStep(step);
    }
    
    function prevStep(step) {
        if (step === 1) showOnboardingStep(1);
        else if (step === 2) {
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
            if (onboardingAccommodation === 'hostel') document.getElementById('step2').classList.remove('hidden');
            else if (onboardingAccommodation === 'pg') document.getElementById('step2-pg').classList.remove('hidden');
            else if (onboardingAccommodation === 'day_scholar') document.getElementById('step2-day').classList.remove('hidden');
            
            document.getElementById('progressBar').style.width = '50%';
            document.getElementById('stepIndicator').textContent = 'Step 2 of 4';
            currentOnboardingStep = 2;
        } else showOnboardingStep(step);
    }
    
    function completeOnboarding() {
        const name = document.getElementById('userName').value || 'Student';
        Swal.fire('Success', `Welcome ${name}! Your profile has been created.`, 'success').then(() => {
            closeOnboardingModal();
        });
    }
</script>

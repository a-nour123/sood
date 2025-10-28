// 1. horizontal wizard
"use strict";
var currentTab = 0;
showTab(currentTab);
function showTab(n) {
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == x.length - 1) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  fixStepIndicator(n);
}
function nextPrev(n) {
  var x = document.getElementsByClassName("tab");
  if (n == 1 && !validateForm()) return false;
  x[currentTab].style.display = "none";
  currentTab = currentTab + n;
  if (currentTab >= x.length) {
    document.getElementById("regForm").submit();
    return false;
  }
  showTab(currentTab);
}
function validateForm() {
  var x,
    y,
    i,
    valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  for (i = 0; i < y.length; i++) {
    if (y[i].value == "") {
      y[i].className += " invalid";
      valid = false;
    }
  }
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid;
}
function fixStepIndicator(n) {
  var i,
    x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  x[n].className += " active";
}

// 2. Numbering wizard
var form = document.getElementById("msform");
var fieldsets = form.querySelectorAll("form");
var currentStep = 0;
var numSteps = 5;

for (var i = 1; i < fieldsets.length; i++) {
  fieldsets[i].style.display = "none";
}


function nextStep() {
    console.log('currentStep ' + currentStep);

    // Enable the back button
    document.getElementById("backbtn").disabled = false;

    // Get the campaign type
    let campaignType = document.getElementById('type_of_campaign').value;

    // Define the total number of steps/forms based on campaign type
    let totalForms = 0;
    switch (campaignType) {
        case 'simulated_phishing':
            totalForms = 4; // Only 4 forms
            break;
        case 'security_awareness':
            totalForms = 3; // Only 3 forms
            break;
        case 'simulated_phishing_and_security_awareness':
            totalForms = 5; // All 5 forms
            break;
        default:
            console.error('Invalid campaign type');
            return;
    }

    // Increment the current step
    currentStep++;
    if (currentStep > totalForms) {
        currentStep = 1; // Loop back to the first form if exceeding the number of forms
    }

    if(currentStep == totalForms){
        return ;
    }

    // Get the stepper and steps
    var stepper = document.getElementById("stepper1");
    var steps = stepper.getElementsByClassName("step");

    // Hide all forms initially
    $('#form-step-one, #form-step-two, #form-step-three, #form-step-four, #form-step-five').hide();

    // Show forms conditionally based on the current step and campaign type
    switch (campaignType) {
        case 'simulated_phishing':
            // if (currentStep === 1) $('#form-step-one').show(); // $('#form-step-one') is by default show at first in currentStep = 0
            if (currentStep === 1) $('#form-step-two').show();
            if (currentStep === 2) $('#form-step-three').show();
            if (currentStep === 3) $('#form-step-four').show();
            break;

        case 'security_awareness':
            // if (currentStep === 1) $('#form-step-one').show();
            if (currentStep === 1) $('#form-step-five').show(); // form 2 and 3 skipped
            if (currentStep === 2) $('#form-step-four').show(); // showing form 5
            break;

        case 'simulated_phishing_and_security_awareness':
            // if (currentStep === 1) $('#form-step-one').show();
            if (currentStep === 1) $('#form-step-two').show();
            if (currentStep === 2) $('#form-step-five').show();
            if (currentStep === 3) $('#form-step-three').show();
            if (currentStep === 4) $('#form-step-four').show();
            break;
    }

    // Loop through steps and update classes and visibility
    console.log('khaled -step : ' + currentStep);
    Array.from(steps).forEach((step, index) => {
        let stepNum = index + 1; // 1-based step number

        if (stepNum <= totalForms -1) {
            if (stepNum === currentStep) {
                addClass(step, "editing");
            } else {
                removeClass(step, "editing");
            }

            if (stepNum <= currentStep) {
                addClass(step, "done");
            } else {
                removeClass(step, "done");
            }

            if (currentStep === totalForms-1) {
                document.getElementById("nextbtn").textContent = "Finish";
            } else {
                document.getElementById("nextbtn").textContent = "Next";
            }
        } else {
            // Hide steps that should not be displayed based on the campaign type
            removeClass(step, "active");
            removeClass(step, "editing");
        }
    });

    // Disable the "Next" button on the last step
    if (currentStep > totalForms) {
        document.getElementById("nextbtn").disabled = false;
    }
}


// function backStep() {
//   currentStep--;
//   var stepper = document.getElementById("stepper1");
//   var steps = stepper.getElementsByClassName("step");
//   let stepLength = steps.length;

//   document.getElementById("nextbtn").textContent = "Next";
//   document.getElementById("nextbtn").disabled = false;
//   if (currentStep < stepLength - 1) {
//     document.getElementById("backbtn").disabled = false;
//     fieldsets[currentStep + 1].style.display = "none";
//     fieldsets[currentStep].style.display = "flex";
//     removeClass(steps[currentStep], "done");
//     removeClass(steps[currentStep], "active");
//     if (currentStep == 0) {
//       document.getElementById("backbtn").disabled = true;
//     }
//   } else {
//     removeClass(steps[currentStep], "done");
//     removeClass(steps[currentStep], "active");
//   }
// }

function backStep() {
    // Decrement the current step
    currentStep--;
    var stepper = document.getElementById("stepper1");
    var steps = stepper.getElementsByClassName("step");
    let campaignType = document.getElementById('type_of_campaign').value;

    // Define the total number of forms based on campaign type
    let totalForms = 0;
    switch (campaignType) {
        case 'simulated_phishing':
            totalForms = 4; // Only 4 forms
            break;
        case 'security_awareness':
            totalForms = 3; // Only 3 forms
            break;
        case 'simulated_phishing_and_security_awareness':
            totalForms = 5; // All 5 forms
            break;
        default:
            console.error('Invalid campaign type');
            return;
    }

    // Update button text and state
    document.getElementById("nextbtn").textContent = "Next";
    document.getElementById("nextbtn").disabled = false;

    // Hide all forms initially
    $('#form-step-one, #form-step-two, #form-step-three, #form-step-four, #form-step-five').hide();

    // Show the current form based on the campaign type
    switch (campaignType) {
        case 'simulated_phishing':
            if (currentStep === 0) $('#form-step-one').show();
            if (currentStep === 1) $('#form-step-two').show();
            if (currentStep === 2) $('#form-step-three').show();
            if (currentStep === 3) $('#form-step-four').show();
            break;

        case 'security_awareness':
            if (currentStep === 0) $('#form-step-one').show();
            if (currentStep === 1) $('#form-step-five').show(); // Only show form 5
            if (currentStep === 2) $('#form-step-four').show(); // Only show form 4
            break;

        case 'simulated_phishing_and_security_awareness':
            if (currentStep === 0) $('#form-step-one').show();
            if (currentStep === 1) $('#form-step-two').show();
            if (currentStep === 2) $('#form-step-five').show();
            if (currentStep === 3) $('#form-step-three').show();
            if (currentStep === 4) $('#form-step-four').show();
            break;
    }

    // Update step classes and states
    Array.from(steps).forEach((step, index) => {
        let stepNum = index + 1; // 1-based step number

        if (stepNum <= totalForms) {
            if (stepNum === currentStep) {
                addClass(step, "editing");
            } else {
                removeClass(step, "editing");
            }

            if (stepNum <= currentStep) {
                addClass(step, "done");
            } else {
                removeClass(step, "done");
            }

            // Disable the back button if on the first step
            if (currentStep <= 0) {
                document.getElementById("backbtn").disabled = true;
            } else {
                document.getElementById("backbtn").disabled = false;
            }
        } else {
            removeClass(step, "active");
        }
    });

    // Show the correct form for the current step
    if (currentStep < 0) {
        currentStep = 0; // Prevent going below the first step
    }
}



function hasClass(elem, className) {
  return new RegExp(" " + className + " ").test(" " + elem.className + " ");
}

function addClass(elem, className) {
  if (!hasClass(elem, className)) {
    elem.className += " " + className;
  }
}

function removeClass(elem, className) {
  var newClass = " " + elem.className.replace(/[\t\r\n]/g, " ") + " ";
  if (hasClass(elem, className)) {
    while (newClass.indexOf(" " + className + " ") >= 0) {
      newClass = newClass.replace(" " + className + " ", " ");
    }
    elem.className = newClass.replace(/^\s+|\s+$/g, "");
  }
}

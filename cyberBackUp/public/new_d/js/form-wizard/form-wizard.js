// 1. horizontal wizard
"use strict";
var currentTab = 0;

// Multiple language support
const locales = {
    en: {
        prev: "Previous",
        next: "Next",
        submit: "Submit",
        finish: "Finish",
    },
    ar: {
        prev: "السابق",
        next: "التالي",
        submit: "إرسال",
        finish: "إنهاء",
    },
    // Add more languages as needed
};

// Function to detect and set locale automatically
function detectLocale() {
    // Get locale from meta tag
    const localeMeta = document.querySelector('meta[name="locale"]');
    const locale = localeMeta ? localeMeta.getAttribute("content") : "en";

    // Check if Arabic
    if (locale === "ar") {
        return "ar";
    }

    // Default to English for all other languages
    return "en";
}

// Set current locale based on detection
let currentLocale = detectLocale();

// Function to set locale
function setLocale(localeKey) {
    if (locales[localeKey]) {
        currentLocale = localeKey;
        updateAllTexts(); // Update all texts when locale changes
        updateTextDirection(); // Update text direction for RTL languages
    } else {
        console.warn(`Locale '${localeKey}' not found, using default 'en'`);
        currentLocale = "en";
        updateAllTexts();
        updateTextDirection();
    }
}

// Function to update text direction for RTL languages
function updateTextDirection() {
    const body = document.body;
    const forms = document.querySelectorAll("form");

    if (currentLocale === "ar") {
        // Set RTL for Arabic
        body.style.direction = "rtl";
        body.style.textAlign = "right";
        forms.forEach((form) => {
            form.style.direction = "rtl";
            form.style.textAlign = "right";
        });

        // Optional: Add RTL-specific CSS class
        body.classList.add("rtl");
        body.classList.remove("ltr");
    } else {
        // Set LTR for other languages
        body.style.direction = "ltr";
        body.style.textAlign = "left";
        forms.forEach((form) => {
            form.style.direction = "ltr";
            form.style.textAlign = "left";
        });

        // Optional: Add LTR-specific CSS class
        body.classList.add("ltr");
        body.classList.remove("rtl");
    }
}

// Function to get current locale text
function getText(key) {
    return locales[currentLocale][key] || locales["en"][key] || key;
}

// Function to update all texts in the UI
function updateAllTexts() {
    // Update horizontal wizard buttons
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const backBtn = document.getElementById("backbtn");
    const nextStepBtn = document.getElementById("nextbtn");

    if (prevBtn) prevBtn.innerHTML = getText("prev");
    if (nextBtn)
        nextBtn.innerHTML =
            currentTab === document.getElementsByClassName("tab").length - 1
                ? getText("submit")
                : getText("next");
    if (backBtn) backBtn.innerHTML = getText("prev");
    if (nextStepBtn) {
        const steps =
            document
                .getElementById("stepper1")
                ?.getElementsByClassName("step") || [];
        nextStepBtn.innerHTML =
            currentStep >= steps.length - 1
                ? getText("finish")
                : getText("next");
    }
}

// Initialize with detected locale
setLocale(currentLocale); // This will automatically detect and set the language

// Rest of your existing code remains the same...
showTab(currentTab);

function showTab(n) {
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
        document.getElementById("prevBtn").innerHTML = getText("prev");
    }
    if (n == x.length - 1) {
        document.getElementById("nextBtn").innerHTML = getText("submit");
    } else {
        document.getElementById("nextBtn").innerHTML = getText("next");
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
        document.getElementsByClassName("step")[currentTab].className +=
            " finish";
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
    console.log("currentStep" + currentStep);
    // Enable the back button
    document.getElementById("backbtn").disabled = false;
    document.getElementById("backbtn").innerHTML = getText("prev");

    // Increment the current step
    currentStep++;
    if (currentStep > numSteps) {
        console.log("catched problem");
        console.log("currentStep" + currentStep);
        currentStep = 1;
    }

    var stepper = document.getElementById("stepper1");
    var steps = stepper.getElementsByClassName("step");

    Array.from(steps).forEach((step, index) => {
        let stepNum = index + 1;
        let stepLength = steps.length;

        if (fieldsets[currentStep]) {
            if (stepNum === currentStep && currentStep < stepLength) {
                addClass(step, "editing");
                fieldsets[currentStep].style.display = "flex";
            } else {
                removeClass(step, "editing");
            }
        }

        if (stepNum <= currentStep && currentStep < stepLength) {
            addClass(step, "done");
            addClass(step, "active");
            removeClass(step, "editing");
            fieldsets[currentStep - 1].style.display = "none";
        } else {
            removeClass(step, "done");
        }

        // Update button text based on locale
        if (currentStep == stepLength - 1) {
            document.getElementById("nextbtn").textContent = getText("finish");
        } else if (currentStep < stepLength - 1) {
            document.getElementById("nextbtn").textContent = getText("next");
        }

        if (currentStep > stepLength - 1) {
            document.getElementById("nextbtn").textContent = getText("finish");
            addClass(step, "done");
            addClass(step, "active");
            removeClass(step, "editing");
            document.getElementById("nextbtn").disabled = true;
        }
    });
}

function backStep() {
    currentStep--;
    var stepper = document.getElementById("stepper1");
    var steps = stepper.getElementsByClassName("step");
    let stepLength = steps.length;

    document.getElementById("nextbtn").textContent = getText("next");
    document.getElementById("nextbtn").disabled = false;

    if (currentStep < stepLength - 1) {
        document.getElementById("backbtn").disabled = false;
        document.getElementById("backbtn").innerHTML = getText("prev");
        fieldsets[currentStep + 1].style.display = "none";
        fieldsets[currentStep].style.display = "flex";
        removeClass(steps[currentStep], "done");
        removeClass(steps[currentStep], "active");
        if (currentStep == 0) {
            document.getElementById("backbtn").disabled = true;
        }
    } else {
        removeClass(steps[currentStep], "done");
        removeClass(steps[currentStep], "active");
    }
}

/* get, set class functions */
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

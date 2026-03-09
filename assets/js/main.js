// Dynamic MCQ functionality - no more static data needed
// MCQ cards are now rendered by PHP from the database

console.log('BoldMCQs Pro main.js loaded successfully');

let isQuizMode = false;
let quizAnswers = {};
let quizModeInitialized = false;

// Check for quiz mode state from URL or localStorage on page load
function initializeQuizModeState() {
    // Check URL parameters first
    const urlParams = new URLSearchParams(window.location.search);
    const quizModeParam = urlParams.get('quiz_mode');
    
    console.log('Current URL:', window.location.href);
    console.log('URL parameters:', window.location.search);
    console.log('Quiz mode parameter:', quizModeParam);
    
    if (quizModeParam === '1' || quizModeParam === 'true') {
        isQuizMode = true;
        localStorage.setItem('boldmcqs_quiz_mode', 'true');
        console.log('Quiz mode activated from URL parameter');
    } else if (quizModeParam === '0' || quizModeParam === 'false') {
        isQuizMode = false;
        localStorage.setItem('boldmcqs_quiz_mode', 'false');
        console.log('Quiz mode deactivated from URL parameter');
    } else {
        // Fall back to localStorage if no URL parameter
        const savedState = localStorage.getItem('boldmcqs_quiz_mode');
        isQuizMode = savedState === 'true';
        console.log('Quiz mode state from localStorage:', savedState, '-> isQuizMode:', isQuizMode);
    }
    
    console.log('Quiz mode state initialized:', isQuizMode);
    return isQuizMode;
}

// Theme functionality
const themeToggle = document.getElementById("themeToggle");
const themeDropdown = document.getElementById("themeDropdown");
const html = document.documentElement;

// Load saved preferences
const currentMode = localStorage.getItem("mode") || "light";
const currentColorTheme = localStorage.getItem("colorTheme") || "blue";

if (currentMode === "dark") {
  html.classList.add("dark");
}

document.body.className = document.body.className.replace(
  /theme-\w+/,
  `theme-${currentColorTheme}`
);

if (themeToggle && themeDropdown) {
  themeToggle.addEventListener("click", (e) => {
    e.stopPropagation();
    themeDropdown.classList.toggle("hidden");
  });

  document.addEventListener("click", (e) => {
    if (!themeToggle.contains(e.target) && !themeDropdown.contains(e.target)) {
      themeDropdown.classList.add("hidden");
    }
  });
}

function toggleLightDark() {
  const isDark = html.classList.contains("dark");
  const modeIcon = document.getElementById("modeIcon");
  const modeText = document.getElementById("modeText");

  if (isDark) {
    html.classList.remove("dark");
    localStorage.setItem("mode", "light");
    if (modeIcon) modeIcon.textContent = "☀️";
    if (modeText) modeText.textContent = "Switch to Dark";
  } else {
    html.classList.add("dark");
    localStorage.setItem("mode", "dark");
    if (modeIcon) modeIcon.textContent = "🌙";
    if (modeText) modeText.textContent = "Switch to Light";
  }
  if (themeDropdown) themeDropdown.classList.add("hidden");
  document.body.style.transform = "scale(0.98)";
  setTimeout(() => {
    document.body.style.transform = "scale(1)";
  }, 150);
}

function setColorTheme(theme) {
  document.body.className = document.body.className.replace(
    /theme-\w+/,
    `theme-${theme}`
  );
  localStorage.setItem("colorTheme", theme);
  if (themeDropdown) themeDropdown.classList.add("hidden");
  document.body.style.transform = "scale(0.98)";
  setTimeout(() => {
    document.body.style.transform = "scale(1)";
  }, 150);
}

function initializeThemeUI() {
  const isDark = html.classList.contains("dark");
  const modeIcon = document.getElementById("modeIcon");
  const modeText = document.getElementById("modeText");
  // Guard: theme toggle may have been removed from the header
  if (!modeIcon || !modeText) return;
  if (isDark) {
    modeIcon.textContent = "🌙";
    modeText.textContent = "Switch to Light";
  } else {
    modeIcon.textContent = "☀️";
    modeText.textContent = "Switch to Dark";
  }
}

initializeThemeUI();

// Search functionality
function initializeSearch() {
    const searchForm = document.querySelector('form[role="search"]');
    const searchInput = searchForm?.querySelector('input[name="s"]');
    
    if (searchForm && searchInput) {
        // Add search suggestions
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length >= 2) {
                // You can add AJAX search suggestions here
                // For now, we'll just add a visual indicator
                this.classList.add('searching');
            } else {
                this.classList.remove('searching');
            }
        });
        
        // Add search form enhancement
        searchForm.addEventListener('submit', function(e) {
            const query = searchInput.value.trim();
            if (!query) {
                e.preventDefault();
                searchInput.focus();
                searchInput.classList.add('border-red-500');
                setTimeout(() => {
                    searchInput.classList.remove('border-red-500');
                }, 2000);
                return false;
            }
        });
        
        // Add keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + K to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
        });
    }
}

// Mobile menu functionality
function initializeMobileMenu() {
  const mobileMenuToggle = document.getElementById('mobileMenuToggle');
  const mobileMenu = document.getElementById('mobileMenu');
  const hamburgerIcon = mobileMenuToggle?.querySelector('.block');
  const closeIcon = mobileMenuToggle?.querySelector('.hidden');
  
  if (mobileMenuToggle && mobileMenu) {
    mobileMenuToggle.addEventListener('click', () => {
      const isOpen = !mobileMenu.classList.contains('hidden');
      
      if (isOpen) {
        // Close menu
        mobileMenu.classList.add('hidden');
        hamburgerIcon?.classList.remove('hidden');
        hamburgerIcon?.classList.add('block');
        closeIcon?.classList.remove('block');
        closeIcon?.classList.add('hidden');
      } else {
        // Open menu
        mobileMenu.classList.remove('hidden');
        hamburgerIcon?.classList.remove('block');
        hamburgerIcon?.classList.add('hidden');
        closeIcon?.classList.remove('hidden');
        closeIcon?.classList.add('block');
      }
    });
    
    // Close mobile menu when clicking on a link
    const mobileMenuLinks = mobileMenu.querySelectorAll('a');
    mobileMenuLinks.forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
        hamburgerIcon?.classList.remove('hidden');
        hamburgerIcon?.classList.add('block');
        closeIcon?.classList.remove('block');
        closeIcon?.classList.add('hidden');
      });
    });
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
      if (!mobileMenuToggle.contains(e.target) && !mobileMenu.contains(e.target)) {
        mobileMenu.classList.add('hidden');
        hamburgerIcon?.classList.remove('hidden');
        hamburgerIcon?.classList.add('block');
        closeIcon?.classList.remove('block');
        closeIcon?.classList.add('hidden');
      }
    });
    
    // Close mobile menu on window resize
    window.addEventListener('resize', () => {
      if (window.innerWidth >= 768) { // md breakpoint
        mobileMenu.classList.add('hidden');
        hamburgerIcon?.classList.remove('hidden');
        hamburgerIcon?.classList.add('block');
        closeIcon?.classList.remove('block');
        closeIcon?.classList.add('hidden');
      }
    });
  }
}

// Initialize mobile menu when DOM is loaded
document.addEventListener('DOMContentLoaded', initializeMobileMenu);
document.addEventListener('DOMContentLoaded', initializeSearch);

// New dynamic quiz functionality for PHP-rendered content
function updateQuizDisplay() {
  const mcqCards = document.querySelectorAll('.mcq-card');
  
  mcqCards.forEach(card => {
    const mcqId = parseInt(card.dataset.mcqId);
    const correctOption = card.dataset.correctOption;
    const options = card.querySelectorAll('.mcq-option');
    const practiceLetters = card.querySelectorAll('.practice-letter');
    const quizRadios = card.querySelectorAll('.quiz-radio');
    
    if (isQuizMode) {
      // Show quiz mode elements
      practiceLetters.forEach(letter => letter.style.display = 'none');
      quizRadios.forEach(radio => radio.style.display = 'flex');
      
      options.forEach((option, index) => {
        const isSelected = quizAnswers[mcqId] === index;
        const isCorrect = correctOption === 'ABCD'[index];
        const showResult = quizAnswers[mcqId] !== undefined;
        const radio = option.querySelector('.quiz-radio');
        const indicator = option.querySelector('.correct-indicator');
        
        // Reset classes
        option.className = 'mcq-option flex items-center p-3 rounded-lg border-2 cursor-pointer transition-all duration-200 ';
        
        if (showResult) {
          // Question is answered - disable cursor and remove hover effects
          option.style.cursor = 'default';
          
          if (isSelected) {
            if (isCorrect) {
              option.className += 'border-secondary bg-secondary/10 dark:bg-secondary/20 text-secondary dark:text-secondary';
              if (radio) {
              radio.className = 'quiz-radio w-4 h-4 rounded-full border-2 border-secondary bg-secondary flex items-center justify-center';
              radio.innerHTML = '<div class="w-2 h-2 bg-white rounded-full"></div>';
              }
            } else {
              option.className += 'border-red-500 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300';
              if (radio) {
              radio.className = 'quiz-radio w-4 h-4 rounded-full border-2 border-red-500 bg-red-500 flex items-center justify-center';
              radio.innerHTML = '<div class="w-2 h-2 bg-white rounded-full"></div>';
              }
            }
          } else if (isCorrect) {
            option.className += 'border-secondary bg-secondary/10 dark:bg-secondary/20 text-secondary dark:text-secondary';
            if (indicator) {
            indicator.style.display = 'inline';
            }
          } else {
            option.className += 'border-gray-200 dark:border-gray-600 opacity-60';
          }
        } else {
          // Question not answered yet - keep interactive cursor and hover effects
          option.style.cursor = 'pointer';
          option.className += 'border-gray-200 dark:border-gray-600 hover:border-primary hover:bg-primary/5';
          if (radio) {
          radio.className = 'quiz-radio w-4 h-4 rounded-full border-2 border-gray-300 flex items-center justify-center';
          radio.innerHTML = '';
          }
        }
        
        if ((!showResult || !isCorrect) && indicator) {
          indicator.style.display = 'none';
        }
      });
    } else {
      // Show practice mode elements
      practiceLetters.forEach(letter => {
        if (letter) letter.style.display = 'inline';
      });
      quizRadios.forEach(radio => {
        if (radio) radio.style.display = 'none';
      });
      
      options.forEach(option => {
        option.className = 'mcq-option flex items-center p-3 rounded-lg border-2 cursor-pointer transition-all duration-200 border-gray-200 dark:border-gray-600 hover:border-primary hover:bg-primary/5';
        const indicator = option.querySelector('.correct-indicator');
        if (indicator) {
        indicator.style.display = 'none';
        }
      });
    }
  });
}

function toggleExplanation(mcqId) {
  const explanation = document.getElementById(`explanation-${mcqId}`);
  const isHidden = explanation.classList.contains("hidden");
  
  explanation.classList.toggle("hidden");
  
  // If we're showing the explanation and NOT in quiz mode, also show the correct answer
  if (isHidden && !isQuizMode) {
    showCorrectAnswer(mcqId);
  } else if (!isHidden && !isQuizMode) {
    // If we're hiding the explanation, reset the MCQ to default state
    resetMCQToDefault(mcqId);
  }
}

function selectAnswer(mcqId, optionIndex) {
  if (!isQuizMode) return;
  
  // Check if this question is already answered
  if (quizAnswers[mcqId] !== undefined) {
    // Already answered, don't allow re-selection
    return;
  }
  
  // Record the answer
  quizAnswers[mcqId] = optionIndex;
  updateQuizDisplay();
}

// Reset single MCQ card to default practice state
function resetMCQToDefault(mcqId) {
  const card = document.querySelector(`[data-mcq-id="${mcqId}"]`);
  if (!card) return;
  
  const options = card.querySelectorAll('.mcq-option');
  const practiceLetters = card.querySelectorAll('.practice-letter');
  const quizRadios = card.querySelectorAll('.quiz-radio');
  const indicators = card.querySelectorAll('.correct-indicator');
  
  // Show practice mode elements
  practiceLetters.forEach(letter => {
    if (letter) letter.style.display = 'inline';
  });
  quizRadios.forEach(radio => {
    if (radio) radio.style.display = 'none';
  });
  
  // Reset all options to default practice state
  options.forEach(option => {
    option.className = 'mcq-option flex items-center p-3 rounded-lg border-2 cursor-pointer transition-all duration-200 border-gray-200 dark:border-gray-600 hover:border-primary hover:bg-primary/5';
    option.style.cursor = 'pointer';
    
    // Reset radio buttons
    const radio = option.querySelector('.quiz-radio');
    if (radio) {
      radio.className = 'quiz-radio w-4 h-4 rounded-full border-2 border-gray-300 hidden items-center justify-center';
      radio.innerHTML = '';
    }
  });
  
  // Hide all indicators
  indicators.forEach(indicator => {
    if (indicator) indicator.style.display = 'none';
  });
}

// Reset all MCQ cards to default practice state
function resetAllMCQsToDefault() {
  const mcqCards = document.querySelectorAll('.mcq-card');
  
  mcqCards.forEach(card => {
    const options = card.querySelectorAll('.mcq-option');
    const practiceLetters = card.querySelectorAll('.practice-letter');
    const quizRadios = card.querySelectorAll('.quiz-radio');
    const indicators = card.querySelectorAll('.correct-indicator');
    
    // Show practice mode elements
    practiceLetters.forEach(letter => {
      if (letter) letter.style.display = 'inline';
    });
    quizRadios.forEach(radio => {
      if (radio) radio.style.display = 'none';
    });
    
    // Reset all options to default practice state
    options.forEach(option => {
      option.className = 'mcq-option flex items-center p-3 rounded-lg border-2 cursor-pointer transition-all duration-200 border-gray-200 dark:border-gray-600 hover:border-primary hover:bg-primary/5';
      option.style.cursor = 'pointer';
      
      // Reset radio buttons
      const radio = option.querySelector('.quiz-radio');
      if (radio) {
        radio.className = 'quiz-radio w-4 h-4 rounded-full border-2 border-gray-300 hidden items-center justify-center';
        radio.innerHTML = '';
      }
    });
    
    // Hide all indicators
    indicators.forEach(indicator => {
      if (indicator) indicator.style.display = 'none';
    });
  });
}

// Show correct answer in practice mode
function showCorrectAnswer(mcqId) {
  const card = document.querySelector(`[data-mcq-id="${mcqId}"]`);
  if (!card) return;
  
  const correctOption = card.dataset.correctOption;
  const options = card.querySelectorAll('.mcq-option');
  
  options.forEach((option, index) => {
    const isCorrect = correctOption === 'ABCD'[index];
    const indicator = option.querySelector('.correct-indicator');
    
    if (isCorrect) {
      // Highlight correct answer in green
      option.className = 'mcq-option flex items-center p-3 rounded-lg border-2 cursor-pointer transition-all duration-200 border-green-500 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300';
      if (indicator) {
      indicator.style.display = 'inline';
      }
    } else {
      // Reset other options
      option.className = 'mcq-option flex items-center p-3 rounded-lg border-2 cursor-pointer transition-all duration-200 border-gray-200 dark:border-gray-600 opacity-60';
      if (indicator) {
      indicator.style.display = 'none';
      }
    }
  });
}

// Setup event listeners for MCQ options
function setupMCQOptionListeners() {
  const mcqOptions = document.querySelectorAll('.mcq-option');
  
  mcqOptions.forEach(option => {
    option.addEventListener('click', function(e) {
      e.preventDefault();
      e.stopPropagation();
      
      const mcqId = parseInt(this.dataset.mcqId);
      const optionIndex = parseInt(this.dataset.optionIndex);
      
      if (isQuizMode) {
        // In quiz mode - only allow one selection per question
        if (quizAnswers[mcqId] !== undefined) {
          // Already answered, don't allow re-selection
          return;
        }
        
        // Record the answer and update display
        selectAnswer(mcqId, optionIndex);
      } else {
        // In practice mode - do nothing when clicking options
        // Users should use "Show Explanation" button to see answers
        return;
      }
    });
  });
}

// Robust quiz mode initialization using event delegation
function initializeQuizMode() {
  if (quizModeInitialized) return; // Prevent multiple initializations
  
  // Use event delegation on the document body
  document.body.addEventListener('click', function(event) {
    console.log('Click detected on:', event.target.tagName, event.target.id, event.target.className);
    
    // Check if the clicked element is the quiz mode button
    if (event.target && event.target.id === 'quizModeBtn') {
      console.log('Quiz mode button clicked! Current state:', isQuizMode);
      event.preventDefault();
      event.stopPropagation();
      
      if (isQuizMode) {
        console.log('Exiting quiz mode...');
        exitQuizMode();
      } else {
        console.log('Starting quiz mode...');
        startQuizMode();
      }
    }
    
    // Check if the clicked element is the exit quiz button
    if (event.target && event.target.id === 'exitQuizBtn') {
      console.log('Exit quiz button clicked!');
      event.preventDefault();
      event.stopPropagation();
      
      exitQuizMode();
    }
  });
  
  quizModeInitialized = true;
}

function startQuizMode() {
  console.log('Starting quiz mode');
  isQuizMode = true;
  quizAnswers = {};
  
  // Save state to localStorage
  localStorage.setItem('boldmcqs_quiz_mode', 'true');
  console.log('Quiz mode state saved to localStorage: true');
  
  const quizBanner = document.getElementById("quizBanner");
  const quizModeBtn = document.getElementById("quizModeBtn");
  
  if (quizBanner) {
    quizBanner.classList.remove("hidden");
  }
  
  if (quizModeBtn) {
    // Update button text and styling
    quizModeBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> Practice Mode';
    quizModeBtn.className = "w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2 sm:py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 text-sm sm:text-base";
  }
  
  updateQuizDisplay();
  console.log('Quiz mode started');
}

function exitQuizMode() {
  console.log('Exiting quiz mode');
  isQuizMode = false;
  quizAnswers = {};
  
  // Save state to localStorage
  localStorage.setItem('boldmcqs_quiz_mode', 'false');
  console.log('Quiz mode state saved to localStorage: false');
  
  const quizBanner = document.getElementById("quizBanner");
  const quizModeBtn = document.getElementById("quizModeBtn");
  
  if (quizBanner) {
    quizBanner.classList.add("hidden");
  }
  
  if (quizModeBtn) {
    // Update button text and styling
    quizModeBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg> Start Quiz Mode';
    quizModeBtn.className = "w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-secondary to-primary text-white rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 text-sm sm:text-base";
  }
  
  // Reset all MCQs to clean practice state
  resetAllMCQsToDefault();
  updateQuizDisplay();
  console.log('Quiz mode exited');
}

// localStorage-based quiz mode - no URL manipulation needed

// Initialize quiz mode functionality
document.addEventListener('DOMContentLoaded', function() {
  console.log('DOM loaded, initializing quiz mode');
  
  // Check if elements exist
  const quizModeBtn = document.getElementById('quizModeBtn');
  const quizBanner = document.getElementById('quizBanner');
  const mcqCards = document.querySelectorAll('.mcq-card');
  
  console.log('Quiz mode button found:', !!quizModeBtn);
  console.log('Quiz banner found:', !!quizBanner);
  console.log('MCQ cards found:', mcqCards.length);
  
  // Pure localStorage approach - no URL parameters needed
  console.log('Checking localStorage for quiz mode state...');
  
  const savedQuizMode = localStorage.getItem('boldmcqs_quiz_mode');
  console.log('localStorage quiz mode value:', savedQuizMode);
  
  if (savedQuizMode === 'true') {
    isQuizMode = true;
    console.log('Quiz mode activated from localStorage');
  } else {
    isQuizMode = false;
    console.log('Practice mode active (default or from localStorage)');
  }
  
  console.log('Final quiz mode state:', isQuizMode);
  
  // Initialize quiz mode event handlers
  initializeQuizMode();
  
  // Add event listeners for MCQ options
  setupMCQOptionListeners();
  
  // Initialize display based on current state
  setTimeout(function() {
    if (isQuizMode) {
      // If quiz mode is active, update the UI accordingly
      console.log('Restoring quiz mode UI from localStorage');
      const quizBanner = document.getElementById("quizBanner");
      const quizModeBtn = document.getElementById("quizModeBtn");
      
      if (quizBanner) {
        quizBanner.classList.remove("hidden");
      }
      
      if (quizModeBtn) {
        quizModeBtn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg> Practice Mode';
        quizModeBtn.className = "w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2 sm:py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 text-sm sm:text-base";
      }
    }
    
    updateQuizDisplay();
  }, 100);
  
  console.log('Quiz mode initialization complete');
  
  // localStorage-based persistence - quiz mode state persists automatically across pages
});

// Also initialize on window load as backup
window.addEventListener('load', function() {
  console.log('Window loaded, checking quiz mode');
  if (!quizModeInitialized) {
    initializeQuizMode();
  }
});
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute("href"));
    if (target) {
      target.scrollIntoView({
        behavior: "smooth",
        block: "start",
      });
    }
  });
});

// Copy to clipboard functionality for share buttons
function copyToClipboard(text) {
  if (navigator.clipboard && window.isSecureContext) {
    // Use modern clipboard API
    navigator.clipboard.writeText(text).then(() => {
      showCopyNotification('Link copied to clipboard!');
    }).catch(err => {
      console.error('Failed to copy: ', err);
      fallbackCopyTextToClipboard(text);
    });
  } else {
    // Fallback for older browsers
    fallbackCopyTextToClipboard(text);
  }
}

function fallbackCopyTextToClipboard(text) {
  const textArea = document.createElement("textarea");
  textArea.value = text;
  
  // Avoid scrolling to bottom
  textArea.style.top = "0";
  textArea.style.left = "0";
  textArea.style.position = "fixed";
  
  document.body.appendChild(textArea);
  textArea.focus();
  textArea.select();
  
  try {
    const successful = document.execCommand('copy');
    if (successful) {
      showCopyNotification('Link copied to clipboard!');
    } else {
      showCopyNotification('Failed to copy link', 'error');
    }
  } catch (err) {
    console.error('Fallback: Oops, unable to copy', err);
    showCopyNotification('Failed to copy link', 'error');
  }
  
  document.body.removeChild(textArea);
}

function showCopyNotification(message, type = 'success') {
  // Remove existing notification if any
  const existingNotification = document.querySelector('.copy-notification');
  if (existingNotification) {
    existingNotification.remove();
  }
  
  // Create notification element
  const notification = document.createElement('div');
  notification.className = `copy-notification fixed top-4 right-4 px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300 ${
    type === 'success' 
      ? 'bg-green-500 text-white' 
      : 'bg-red-500 text-white'
  }`;
  notification.textContent = message;
  
  // Add to page
  document.body.appendChild(notification);
  
  // Animate in
  setTimeout(() => {
    notification.style.transform = 'translateX(0)';
    notification.style.opacity = '1';
  }, 10);
  
  // Remove after 3 seconds
  setTimeout(() => {
    notification.style.transform = 'translateX(100%)';
    notification.style.opacity = '0';
    setTimeout(() => {
      if (notification.parentNode) {
        notification.parentNode.removeChild(notification);
      }
    }, 300);
  }, 3000);
}

// Make functions globally available
window.copyToClipboard = copyToClipboard;

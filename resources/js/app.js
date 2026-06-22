import '../css/app.css';

import '@fortawesome/fontawesome-free/css/all.min.css';

/* =========================
   NAVBAR & NAVIGATION - ELEGANT VERSION
========================= */

class NavbarController {
    constructor() {
        this.navbar = document.querySelector('.navbar-travel')
        this.sections = document.querySelectorAll('section[id]')
        this.navLinks = document.querySelectorAll('.travel-link')
        this.lastScrollY = 0
        this.ticking = false
        
        this.init()
    }
    
    init() {
        this.handleInitialState()
        this.bindEvents()
    }
    
    handleInitialState() {
        this.updateNavbar()
        this.updateActiveNav()
    }
    
    bindEvents() {
        // Throttled scroll listener untuk performance
        window.addEventListener('scroll', () => this.requestTick(), { passive: true })
        
        // Resize handler
        window.addEventListener('resize', () => this.requestTick(), { passive: true })
    }
    
    requestTick() {
        if (!this.ticking) {
            requestAnimationFrame(() => {
                this.updateAll()
                this.ticking = false
            })
            this.ticking = true
        }
    }
    
    updateAll() {
        this.updateNavbar()
        this.updateActiveNav()
    }
    
    /* =========================
       NAVBAR SCROLL EFFECT
    ========================= */
    
    updateNavbar() {
        if (!this.navbar) return
        
        const scrolled = window.scrollY > 50
        const directionDown = window.scrollY > this.lastScrollY
        
        // Toggle scrolled class
        this.navbar.classList.toggle('scrolled', scrolled)
        
        // Hide on scroll down (optional smooth UX)
        this.navbar.classList.toggle('hide', scrolled && directionDown && window.scrollY > 100)
        
        this.lastScrollY = window.scrollY
    }
    
    /* =========================
       ACTIVE NAVIGATION
    ========================= */
    
    updateActiveNav() {
        if (this.sections.length === 0) return
        
        let currentSection = ''
        const scrollY = window.scrollY
        const windowHeight = window.innerHeight
        const offset = 150 // Offset untuk smooth activation
        
        // Find current section
        this.sections.forEach(section => {
            const rect = section.getBoundingClientRect()
            const sectionTop = rect.top + scrollY
            const sectionHeight = rect.height
            
            if (scrollY >= (sectionTop - offset) && 
                scrollY < (sectionTop + sectionHeight)) {
                currentSection = section.getAttribute('id')
            }
        })
        
        // Update active links
        this.navLinks.forEach(link => {
            const href = link.getAttribute('href')
            const isActive = href === `#${currentSection}`
            
            link.classList.toggle('active', isActive)
            
            // Smooth opacity transition untuk non-active links
            if (!isActive) {
                link.style.opacity = '0.6'
            } else {
                link.style.opacity = '1'
            }
        })
    }
}

/* =========================
   SMOOTH SCROLL FOR NAV LINKS
========================= */

const setupSmoothScroll = () => {
    document.querySelectorAll('.travel-link').forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href')
            if (href.startsWith('#')) {
                e.preventDefault()
                const target = document.querySelector(href)
                if (target) {
                    const offsetTop = target.offsetTop - 80 // Navbar height offset
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    })
                }
            }
        })
    })
}

/* =========================
   MOBILE MENU TOGGLE (Bonus)
========================= */

const setupMobileMenu = () => {
    const mobileToggle = document.querySelector('.mobile-toggle')
    const mobileMenu = document.querySelector('.mobile-menu')
    
    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('active')
            mobileToggle.classList.toggle('active')
        })
    }
}

/* =========================
   INIT EVERYTHING
========================= */

document.addEventListener('DOMContentLoaded', () => {
    // Initialize main controller
    new NavbarController()
    
    // Setup smooth scroll
    setupSmoothScroll()
    
    // Setup mobile menu
    setupMobileMenu()
    
    console.log('🌟 Navbar Controller Initialized - Ultra Smooth!')
})
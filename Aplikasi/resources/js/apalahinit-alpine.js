function data() {
    function getThemeFromLocalStorage() {
        // if user already changed the theme, use it
        if (window.localStorage.getItem("dark")) {
            return JSON.parse(window.localStorage.getItem("dark"));
        } else {
            return false;
        }
    }

    function setThemeToLocalStorage(value) {
        window.localStorage.setItem("dark", value);
    }

    return {
        dark: getThemeFromLocalStorage(),
        toggleTheme() {
            this.dark = !this.dark;
            setThemeToLocalStorage(this.dark);
        },
        isSideMenuOpen: false,
        toggleSideMenu() {
            this.isSideMenuOpen = !this.isSideMenuOpen;
        },
        closeSideMenu() {
            this.isSideMenuOpen = false;
        },

        isNotificationsMenuOpen: false,
        toggleNotificationsMenu() {
            this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen;
        },
        closeNotificationsMenu() {
            this.isNotificationsMenuOpen = false;
        },

        isDropdownFilterOpen: false,
        toggleDropdownMenu() {
            this.isDropdownFilterOpen = !this.isDropdownFilterOpen;
        },
        closeDropdownMenu() {
            this.isDropdownFilterOpen = false;
        },
        stopClickPropagation(event) {
            event.stopPropagation();
        },

        isProfileMenuOpen: false,
        toggleProfileMenu() {
            this.isProfileMenuOpen = !this.isProfileMenuOpen;
        },
        closeProfileMenu() {
            this.isProfileMenuOpen = false;
        },
        isPagesMenuOpen: false,
        togglePagesMenu() {
            this.isPagesMenuOpen = !this.isPagesMenuOpen;
        },
        // Modal
        // isModalOpen: false,
        // currentModal: null,

        // openModal(modalId) {
        //     this.isModalOpen = true;
        //     this.currentModal = modalId;
        //     this.trapCleanup = focusTrap(document.querySelector(`#${modalId}`));
        // },
        // closeModal() {
        //     this.isModalOpen = false;
        //     this.trapCleanup();
        // },

        isModalOpen: false,
        currentModal: null,
        // trapCleanup: () => {},
        openModal(modal) {
            this.currentModal = modal;
            this.isModalOpen = true;
            // this.trapCleanup = focusTrap(document.querySelector(`#${modal}`));
        },
        closeModal() {
            this.isModalOpen = false;
            this.currentModal = null;
            // if (typeof this.trapCleanup === "function") {
            //     this.trapCleanup();
            // }
        },
    };
}

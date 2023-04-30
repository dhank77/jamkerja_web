import { Link, usePage } from "@inertiajs/inertia-react";
import React, { useEffect } from "react";
import Swal from "sweetalert2";

export default function Authenticated({ children }) {
    const { auth, flash, perusahaan, role } = usePage().props;

    flash.type && Swal.fire(flash.messages, "", flash.type);

    return (
        <div className="d-flex flex-column flex-root app-root" id="kt_app_root">
            <div
                className="app-page flex-column flex-column-fluid"
                id="kt_app_page"
            >
                <div
                    id="kt_app_header"
                    className="app-header"
                    data-kt-sticky="true"
                    data-kt-sticky-activate="{default: false, lg: true}"
                    data-kt-sticky-name="app-header-sticky"
                    data-kt-sticky-offset="{default: false, lg: '300px'}"
                >
                    <div
                        className="app-container container-fluid d-flex flex-stack"
                        id="kt_app_header_container"
                    >
                        <div
                            className="d-flex align-items-center d-block d-lg-none ms-n3"
                            title="Show sidebar menu"
                        >
                            <div
                                className="btn btn-icon btn-active-color-primary w-35px h-35px me-2"
                                id="kt_app_sidebar_mobile_toggle"
                            >
                                <i className="ki-duotone ki-abstract-14 fs-1">
                                    <span className="path1" />
                                    <span className="path2" />
                                </i>
                            </div>
                            <a href="../../demo36/dist/index.html">
                                <img
                                    alt="Logo"
                                    src="/logo.png"
                                    className="h-30px theme-light-show"
                                />
                                <img
                                    alt="Logo"
                                    src="/logo.png"
                                    className="h-30px theme-dark-show"
                                />
                            </a>
                        </div>
                        <div
                            className="d-flex flex-stack flex-lg-row-fluid"
                            id="kt_app_header_wrapper"
                        >
                            <div
                                className="page-title gap-4 me-3 mb-5 mb-lg-0"
                                data-kt-swapper="true"
                                data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}"
                                data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}"
                            >
                                <div className="d-flex align-items-center mb-3">
                                    <a href="/" className="d-flex">
                                        <img
                                            alt="Logo"
                                            src="/logo.png"
                                            className="me-7 d-none d-lg-inline h-45px"
                                        />
                                        <h3>JamKerja.ID</h3>
                                    </a>
                                </div>
                            </div>
                            <Link
                                href={route("logout")}
                                as="button"
                                method="post"
                                className="btn btn-danger d-flex flex-center h-35px h-lg-40px"
                            >
                                <i className="fa fa-sign-out"></i>
                                Logout
                            </Link>
                        </div>
                    </div>
                </div>
                <div
                    className="app-wrapper flex-column flex-row-fluid"
                    id="kt_app_wrapper"
                >
                    <div
                        id="kt_app_sidebar"
                        className="app-sidebar flex-column"
                        data-kt-drawer="true"
                        data-kt-drawer-name="app-sidebar"
                        data-kt-drawer-activate="{default: true, lg: false}"
                        data-kt-drawer-overlay="true"
                        data-kt-drawer-width="250px"
                        data-kt-drawer-direction="start"
                        data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle"
                    >
                        <div
                            className="app-sidebar-header d-flex flex-column px-10 pt-8"
                            id="kt_app_sidebar_header"
                        >
                            <div className="d-flex flex-stack mb-10">
                                <div className>
                                    <div
                                        className="d-flex align-items-center"
                                        data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                        data-kt-menu-overflow="true"
                                        data-kt-menu-placement="top-start"
                                    >
                                        <div className="d-flex flex-center cursor-pointer symbol symbol-custom symbol-40px">
                                            <img
                                                src="/no-image.png"
                                                alt="image"
                                            />
                                        </div>
                                        <a
                                            href="#"
                                            className="text-white text-hover-primary fs-4 fw-bold ms-3"
                                        >
                                            <i className="fs-6">
                                                Selamat Datang,
                                            </i>{" "}
                                            <br />
                                            {auth.user.name}
                                        </a>
                                    </div>
                                    <div
                                        className="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                                        data-kt-menu="true"
                                    >
                                        <div className="menu-item px-5">
                                            <Link
                                                href={route("password.index")}
                                                className="menu-link px-5"
                                            >
                                                Ubah Password
                                            </Link>
                                        </div>
                                        <div className="menu-item px-5">
                                            <Link
                                                href={route("logout")}
                                                as="button"
                                                method="post"
                                                className="menu-link px-5"
                                            >
                                                Logout
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                id="kt_header_search"
                                className="header-search d-flex align-items-center search-custom w-lg-275px mb-1"
                                data-kt-search-keypress="true"
                                data-kt-search-min-length={2}
                                data-kt-search-enter="enter"
                                data-kt-search-layout="menu"
                                data-kt-search-responsive="false"
                                data-kt-menu-trigger="auto"
                                data-kt-menu-permanent="true"
                                data-kt-menu-placement="bottom-start"
                            >
                                <div
                                    data-kt-search-element="content"
                                    className="menu menu-sub menu-sub-dropdown py-7 px-7 overflow-hidden w-300px w-md-350px"
                                >
                                    <div data-kt-search-element="wrapper">
                                        <div
                                            data-kt-search-element="results"
                                            className="d-none"
                                        >
                                            <div className="scroll-y mh-200px mh-lg-350px">
                                                <h3
                                                    className="fs-5 text-muted m-0 pb-5"
                                                    data-kt-search-element="category-title"
                                                >
                                                    Users
                                                </h3>
                                                <a
                                                    href="#"
                                                    className="d-flex text-dark text-hover-primary align-items-center mb-5"
                                                >
                                                    <div className="symbol symbol-40px me-4">
                                                        <img
                                                            src="assets/media/avatars/300-6.jpg"
                                                            alt
                                                        />
                                                    </div>
                                                    <div className="d-flex flex-column justify-content-start fw-semibold">
                                                        <span className="fs-6 fw-semibold">
                                                            Karina Clark
                                                        </span>
                                                        <span className="fs-7 fw-semibold text-muted">
                                                            Marketing Manager
                                                        </span>
                                                    </div>
                                                </a>
                                                <a
                                                    href="#"
                                                    className="d-flex text-dark text-hover-primary align-items-center mb-5"
                                                >
                                                    <div className="symbol symbol-40px me-4">
                                                        <img
                                                            src="/no-image.png"
                                                            alt
                                                        />
                                                    </div>
                                                    <div className="d-flex flex-column justify-content-start fw-semibold">
                                                        <span className="fs-6 fw-semibold">
                                                            Olivia Bold
                                                        </span>
                                                        <span className="fs-7 fw-semibold text-muted">
                                                            Software Engineer
                                                        </span>
                                                    </div>
                                                </a>
                                                <a
                                                    href="#"
                                                    className="d-flex text-dark text-hover-primary align-items-center mb-5"
                                                >
                                                    <div className="symbol symbol-40px me-4">
                                                        <img
                                                            src="assets/media/avatars/300-9.jpg"
                                                            alt
                                                        />
                                                    </div>
                                                    <div className="d-flex flex-column justify-content-start fw-semibold">
                                                        <span className="fs-6 fw-semibold">
                                                            Ana Clark
                                                        </span>
                                                        <span className="fs-7 fw-semibold text-muted">
                                                            UI/UX Designer
                                                        </span>
                                                    </div>
                                                </a>
                                                <a
                                                    href="#"
                                                    className="d-flex text-dark text-hover-primary align-items-center mb-5"
                                                >
                                                    <div className="symbol symbol-40px me-4">
                                                        <img
                                                            src="assets/media/avatars/300-14.jpg"
                                                            alt
                                                        />
                                                    </div>
                                                    <div className="d-flex flex-column justify-content-start fw-semibold">
                                                        <span className="fs-6 fw-semibold">
                                                            Nick Pitola
                                                        </span>
                                                        <span className="fs-7 fw-semibold text-muted">
                                                            Art Director
                                                        </span>
                                                    </div>
                                                </a>
                                                <a
                                                    href="#"
                                                    className="d-flex text-dark text-hover-primary align-items-center mb-5"
                                                >
                                                    <div className="symbol symbol-40px me-4">
                                                        <img
                                                            src="assets/media/avatars/300-11.jpg"
                                                            alt
                                                        />
                                                    </div>
                                                    <div className="d-flex flex-column justify-content-start fw-semibold">
                                                        <span className="fs-6 fw-semibold">
                                                            Edward Kulnic
                                                        </span>
                                                        <span className="fs-7 fw-semibold text-muted">
                                                            System Administrator
                                                        </span>
                                                    </div>
                                                </a>
                                                <h3
                                                    className="fs-5 text-muted m-0 pt-5 pb-5"
                                                    data-kt-search-element="category-title"
                                                >
                                                    Customers
                                                </h3>
                                                <a
                                                    href="#"
                                                    className="d-flex text-dark text-hover-primary align-items-center mb-5"
                                                >
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <img
                                                                className="w-20px h-20px"
                                                                src="assets/media/svg/brand-logos/volicity-9.svg"
                                                                alt
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column justify-content-start fw-semibold">
                                                        <span className="fs-6 fw-semibold">
                                                            Company Rbranding
                                                        </span>
                                                        <span className="fs-7 fw-semibold text-muted">
                                                            UI Design
                                                        </span>
                                                    </div>
                                                </a>
                                                <a
                                                    href="#"
                                                    className="d-flex text-dark text-hover-primary align-items-center mb-5"
                                                >
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <img
                                                                className="w-20px h-20px"
                                                                src="assets/media/svg/brand-logos/tvit.svg"
                                                                alt
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column justify-content-start fw-semibold">
                                                        <span className="fs-6 fw-semibold">
                                                            Company Re-branding
                                                        </span>
                                                        <span className="fs-7 fw-semibold text-muted">
                                                            Web Development
                                                        </span>
                                                    </div>
                                                </a>
                                                <a
                                                    href="#"
                                                    className="d-flex text-dark text-hover-primary align-items-center mb-5"
                                                >
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <img
                                                                className="w-20px h-20px"
                                                                src="assets/media/svg/misc/infography.svg"
                                                                alt
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column justify-content-start fw-semibold">
                                                        <span className="fs-6 fw-semibold">
                                                            Business Analytics
                                                            App
                                                        </span>
                                                        <span className="fs-7 fw-semibold text-muted">
                                                            Administration
                                                        </span>
                                                    </div>
                                                </a>
                                                <a
                                                    href="#"
                                                    className="d-flex text-dark text-hover-primary align-items-center mb-5"
                                                >
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <img
                                                                className="w-20px h-20px"
                                                                src="assets/media/svg/brand-logos/leaf.svg"
                                                                alt
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column justify-content-start fw-semibold">
                                                        <span className="fs-6 fw-semibold">
                                                            EcoLeaf App Launch
                                                        </span>
                                                        <span className="fs-7 fw-semibold text-muted">
                                                            Marketing
                                                        </span>
                                                    </div>
                                                </a>
                                                <a
                                                    href="#"
                                                    className="d-flex text-dark text-hover-primary align-items-center mb-5"
                                                >
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <img
                                                                className="w-20px h-20px"
                                                                src="assets/media/svg/brand-logos/tower.svg"
                                                                alt
                                                            />
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column justify-content-start fw-semibold">
                                                        <span className="fs-6 fw-semibold">
                                                            Tower Group Website
                                                        </span>
                                                        <span className="fs-7 fw-semibold text-muted">
                                                            Google Adwords
                                                        </span>
                                                    </div>
                                                </a>
                                                <h3
                                                    className="fs-5 text-muted m-0 pt-5 pb-5"
                                                    data-kt-search-element="category-title"
                                                >
                                                    Projects
                                                </h3>
                                                <a
                                                    href="#"
                                                    className="d-flex text-dark text-hover-primary align-items-center mb-5"
                                                >
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <i className="ki-duotone ki-notepad fs-2 text-primary">
                                                                <span className="path1" />
                                                                <span className="path2" />
                                                                <span className="path3" />
                                                                <span className="path4" />
                                                                <span className="path5" />
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column">
                                                        <span className="fs-6 fw-semibold">
                                                            Si-Fi Project by AU
                                                            Themes
                                                        </span>
                                                        <span className="fs-7 fw-semibold text-muted">
                                                            #45670
                                                        </span>
                                                    </div>
                                                </a>
                                                <a
                                                    href="#"
                                                    className="d-flex text-dark text-hover-primary align-items-center mb-5"
                                                >
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <i className="ki-duotone ki-frame fs-2 text-primary">
                                                                <span className="path1" />
                                                                <span className="path2" />
                                                                <span className="path3" />
                                                                <span className="path4" />
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column">
                                                        <span className="fs-6 fw-semibold">
                                                            Shopix Mobile App
                                                            Planning
                                                        </span>
                                                        <span className="fs-7 fw-semibold text-muted">
                                                            #45690
                                                        </span>
                                                    </div>
                                                </a>
                                                <a
                                                    href="#"
                                                    className="d-flex text-dark text-hover-primary align-items-center mb-5"
                                                >
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <i className="ki-duotone ki-message-text-2 fs-2 text-primary">
                                                                <span className="path1" />
                                                                <span className="path2" />
                                                                <span className="path3" />
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column">
                                                        <span className="fs-6 fw-semibold">
                                                            Finance Monitoring
                                                            SAAS Discussion
                                                        </span>
                                                        <span className="fs-7 fw-semibold text-muted">
                                                            #21090
                                                        </span>
                                                    </div>
                                                </a>
                                                <a
                                                    href="#"
                                                    className="d-flex text-dark text-hover-primary align-items-center mb-5"
                                                >
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <i className="ki-duotone ki-profile-circle fs-2 text-primary">
                                                                <span className="path1" />
                                                                <span className="path2" />
                                                                <span className="path3" />
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column">
                                                        <span className="fs-6 fw-semibold">
                                                            Dashboard Analitics
                                                            Launch
                                                        </span>
                                                        <span className="fs-7 fw-semibold text-muted">
                                                            #34560
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                        <div
                                            className
                                            data-kt-search-element="main"
                                        >
                                            <div className="d-flex flex-stack fw-semibold mb-4">
                                                <span className="text-muted fs-6 me-2">
                                                    Recently Searched:
                                                </span>
                                                <div
                                                    className="d-flex"
                                                    data-kt-search-element="toolbar"
                                                >
                                                    <div
                                                        data-kt-search-element="preferences-show"
                                                        className="btn btn-icon w-20px btn-sm btn-active-color-primary me-2 data-bs-toggle="
                                                        title="Show search preferences"
                                                    >
                                                        <i className="ki-duotone ki-setting-2 fs-2">
                                                            <span className="path1" />
                                                            <span className="path2" />
                                                        </i>
                                                    </div>
                                                    <div
                                                        data-kt-search-element="advanced-options-form-show"
                                                        className="btn btn-icon w-20px btn-sm btn-active-color-primary me-n1"
                                                        data-bs-toggle="tooltip"
                                                        title="Show more search options"
                                                    >
                                                        <i className="ki-duotone ki-down fs-2" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div className="scroll-y mh-200px mh-lg-325px">
                                                <div className="d-flex align-items-center mb-5">
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <i className="ki-duotone ki-laptop fs-2 text-primary">
                                                                <span className="path1" />
                                                                <span className="path2" />
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column">
                                                        <a
                                                            href="#"
                                                            className="fs-6 text-gray-800 text-hover-primary fw-semibold"
                                                        >
                                                            BoomApp by
                                                            Keenthemes
                                                        </a>
                                                        <span className="fs-7 text-muted fw-semibold">
                                                            #45789
                                                        </span>
                                                    </div>
                                                </div>
                                                <div className="d-flex align-items-center mb-5">
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <i className="ki-duotone ki-chart-simple fs-2 text-primary">
                                                                <span className="path1" />
                                                                <span className="path2" />
                                                                <span className="path3" />
                                                                <span className="path4" />
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column">
                                                        <a
                                                            href="#"
                                                            className="fs-6 text-gray-800 text-hover-primary fw-semibold"
                                                        >
                                                            "Kept API Project
                                                            Meeting
                                                        </a>
                                                        <span className="fs-7 text-muted fw-semibold">
                                                            #84050
                                                        </span>
                                                    </div>
                                                </div>
                                                <div className="d-flex align-items-center mb-5">
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <i className="ki-duotone ki-chart fs-2 text-primary">
                                                                <span className="path1" />
                                                                <span className="path2" />
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column">
                                                        <a
                                                            href="#"
                                                            className="fs-6 text-gray-800 text-hover-primary fw-semibold"
                                                        >
                                                            "KPI Monitoring App
                                                            Launch
                                                        </a>
                                                        <span className="fs-7 text-muted fw-semibold">
                                                            #84250
                                                        </span>
                                                    </div>
                                                </div>
                                                <div className="d-flex align-items-center mb-5">
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <i className="ki-duotone ki-chart-line-down fs-2 text-primary">
                                                                <span className="path1" />
                                                                <span className="path2" />
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column">
                                                        <a
                                                            href="#"
                                                            className="fs-6 text-gray-800 text-hover-primary fw-semibold"
                                                        >
                                                            Project Reference
                                                            FAQ
                                                        </a>
                                                        <span className="fs-7 text-muted fw-semibold">
                                                            #67945
                                                        </span>
                                                    </div>
                                                </div>
                                                <div className="d-flex align-items-center mb-5">
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <i className="ki-duotone ki-sms fs-2 text-primary">
                                                                <span className="path1" />
                                                                <span className="path2" />
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column">
                                                        <a
                                                            href="#"
                                                            className="fs-6 text-gray-800 text-hover-primary fw-semibold"
                                                        >
                                                            "FitPro App
                                                            Development
                                                        </a>
                                                        <span className="fs-7 text-muted fw-semibold">
                                                            #84250
                                                        </span>
                                                    </div>
                                                </div>
                                                <div className="d-flex align-items-center mb-5">
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <i className="ki-duotone ki-bank fs-2 text-primary">
                                                                <span className="path1" />
                                                                <span className="path2" />
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column">
                                                        <a
                                                            href="#"
                                                            className="fs-6 text-gray-800 text-hover-primary fw-semibold"
                                                        >
                                                            Shopix Mobile App
                                                        </a>
                                                        <span className="fs-7 text-muted fw-semibold">
                                                            #45690
                                                        </span>
                                                    </div>
                                                </div>
                                                <div className="d-flex align-items-center mb-5">
                                                    <div className="symbol symbol-40px me-4">
                                                        <span className="symbol-label bg-light">
                                                            <i className="ki-duotone ki-chart-line-down fs-2 text-primary">
                                                                <span className="path1" />
                                                                <span className="path2" />
                                                            </i>
                                                        </span>
                                                    </div>
                                                    <div className="d-flex flex-column">
                                                        <a
                                                            href="#"
                                                            className="fs-6 text-gray-800 text-hover-primary fw-semibold"
                                                        >
                                                            "Landing UI Design"
                                                            Launch
                                                        </a>
                                                        <span className="fs-7 text-muted fw-semibold">
                                                            #24005
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            data-kt-search-element="empty"
                                            className="text-center d-none"
                                        >
                                            <div className="pt-10 pb-10">
                                                <i className="ki-duotone ki-search-list fs-4x opacity-50">
                                                    <span className="path1" />
                                                    <span className="path2" />
                                                    <span className="path3" />
                                                </i>
                                            </div>
                                            <div className="pb-15 fw-semibold">
                                                <h3 className="text-gray-600 fs-5 mb-2">
                                                    No result found
                                                </h3>
                                                <div className="text-muted fs-7">
                                                    Please try again with a
                                                    different query
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form
                                        data-kt-search-element="advanced-options-form"
                                        className="pt-1 d-none"
                                    >
                                        <h3 className="fw-semibold text-dark mb-7">
                                            Advanced Search
                                        </h3>
                                        <div className="mb-5">
                                            <input
                                                type="text"
                                                className="form-control form-control-sm form-control-solid"
                                                placeholder="Contains the word"
                                                name="query"
                                            />
                                        </div>
                                        <div className="mb-5">
                                            <div className="nav-group nav-group-fluid">
                                                <label>
                                                    <input
                                                        type="radio"
                                                        className="btn-check"
                                                        name="type"
                                                        defaultValue="has"
                                                        defaultChecked="checked"
                                                    />
                                                    <span className="btn btn-sm btn-color-muted btn-active btn-active-primary">
                                                        All
                                                    </span>
                                                </label>
                                                <label>
                                                    <input
                                                        type="radio"
                                                        className="btn-check"
                                                        name="type"
                                                        defaultValue="users"
                                                    />
                                                    <span className="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">
                                                        Users
                                                    </span>
                                                </label>
                                                <label>
                                                    <input
                                                        type="radio"
                                                        className="btn-check"
                                                        name="type"
                                                        defaultValue="orders"
                                                    />
                                                    <span className="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">
                                                        Orders
                                                    </span>
                                                </label>
                                                <label>
                                                    <input
                                                        type="radio"
                                                        className="btn-check"
                                                        name="type"
                                                        defaultValue="projects"
                                                    />
                                                    <span className="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">
                                                        Projects
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div className="mb-5">
                                            <input
                                                type="text"
                                                name="assignedto"
                                                className="form-control form-control-sm form-control-solid"
                                                placeholder="Assigned to"
                                                defaultValue
                                            />
                                        </div>
                                        <div className="mb-5">
                                            <input
                                                type="text"
                                                name="collaborators"
                                                className="form-control form-control-sm form-control-solid"
                                                placeholder="Collaborators"
                                                defaultValue
                                            />
                                        </div>
                                        <div className="mb-5">
                                            <div className="nav-group nav-group-fluid">
                                                <label>
                                                    <input
                                                        type="radio"
                                                        className="btn-check"
                                                        name="attachment"
                                                        defaultValue="has"
                                                        defaultChecked="checked"
                                                    />
                                                    <span className="btn btn-sm btn-color-muted btn-active btn-active-primary">
                                                        Has attachment
                                                    </span>
                                                </label>
                                                <label>
                                                    <input
                                                        type="radio"
                                                        className="btn-check"
                                                        name="attachment"
                                                        defaultValue="any"
                                                    />
                                                    <span className="btn btn-sm btn-color-muted btn-active btn-active-primary px-4">
                                                        Any
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div className="mb-5">
                                            <select
                                                name="timezone"
                                                aria-label="Select a Timezone"
                                                data-control="select2"
                                                data-placeholder="date_period"
                                                className="form-select form-select-sm form-select-solid"
                                            >
                                                <option value="next">
                                                    Within the next
                                                </option>
                                                <option value="last">
                                                    Within the last
                                                </option>
                                                <option value="between">
                                                    Between
                                                </option>
                                                <option value="on">On</option>
                                            </select>
                                        </div>
                                        <div className="row mb-8">
                                            <div className="col-6">
                                                <input
                                                    type="number"
                                                    name="date_number"
                                                    className="form-control form-control-sm form-control-solid"
                                                    placeholder="Lenght"
                                                    defaultValue
                                                />
                                            </div>
                                            <div className="col-6">
                                                <select
                                                    name="date_typer"
                                                    aria-label="Select a Timezone"
                                                    data-control="select2"
                                                    data-placeholder="Period"
                                                    className="form-select form-select-sm form-select-solid"
                                                >
                                                    <option value="days">
                                                        Days
                                                    </option>
                                                    <option value="weeks">
                                                        Weeks
                                                    </option>
                                                    <option value="months">
                                                        Months
                                                    </option>
                                                    <option value="years">
                                                        Years
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div className="d-flex justify-content-end">
                                            <button
                                                type="reset"
                                                className="btn btn-sm btn-light fw-bold btn-active-light-primary me-2"
                                                data-kt-search-element="advanced-options-form-cancel"
                                            >
                                                Cancel
                                            </button>
                                            <a
                                                href="../../demo36/dist/pages/search/horizontal.html"
                                                className="btn btn-sm fw-bold btn-primary"
                                                data-kt-search-element="advanced-options-form-search"
                                            >
                                                Search
                                            </a>
                                        </div>
                                    </form>
                                    <form
                                        data-kt-search-element="preferences"
                                        className="pt-1 d-none"
                                    >
                                        <h3 className="fw-semibold text-dark mb-7">
                                            Search Preferences
                                        </h3>
                                        <div className="pb-4 border-bottom">
                                            <label className="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                <span className="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">
                                                    Projects
                                                </span>
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    defaultValue={1}
                                                    defaultChecked="checked"
                                                />
                                            </label>
                                        </div>
                                        <div className="py-4 border-bottom">
                                            <label className="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                <span className="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">
                                                    Targets
                                                </span>
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    defaultValue={1}
                                                    defaultChecked="checked"
                                                />
                                            </label>
                                        </div>
                                        <div className="py-4 border-bottom">
                                            <label className="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                <span className="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">
                                                    Affiliate Programs
                                                </span>
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    defaultValue={1}
                                                />
                                            </label>
                                        </div>
                                        <div className="py-4 border-bottom">
                                            <label className="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                <span className="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">
                                                    Referrals
                                                </span>
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    defaultValue={1}
                                                    defaultChecked="checked"
                                                />
                                            </label>
                                        </div>
                                        <div className="py-4 border-bottom">
                                            <label className="form-check form-switch form-switch-sm form-check-custom form-check-solid flex-stack">
                                                <span className="form-check-label text-gray-700 fs-6 fw-semibold ms-0 me-2">
                                                    Users
                                                </span>
                                                <input
                                                    className="form-check-input"
                                                    type="checkbox"
                                                    defaultValue={1}
                                                />
                                            </label>
                                        </div>
                                        <div className="d-flex justify-content-end pt-7">
                                            <button
                                                type="reset"
                                                className="btn btn-sm btn-light fw-bold btn-active-light-primary me-2"
                                                data-kt-search-element="preferences-dismiss"
                                            >
                                                Cancel
                                            </button>
                                            <button
                                                type="submit"
                                                className="btn btn-sm fw-bold btn-primary"
                                            >
                                                Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div
                            className="app-sidebar-navs flex-column-fluid"
                            id="kt_app_sidebar_navs"
                        >
                            <div
                                id="kt_app_sidebar_navs_wrappers"
                                className="hover-scroll-y my-2"
                                data-kt-scroll="true"
                                data-kt-scroll-activate="true"
                                data-kt-scroll-height="auto"
                                data-kt-scroll-dependencies="#kt_app_sidebar_header, #kt_app_sidebar_projects"
                                data-kt-scroll-wrappers="#kt_app_sidebar_navs"
                                data-kt-scroll-offset="5px"
                            >
                                <div
                                    id="#kt_app_sidebar_menu"
                                    data-kt-menu="true"
                                    data-kt-menu-expand="false"
                                    className="menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary"
                                >
                                    <div className="menu-item">
                                        <div className="menu-content menu-heading text-uppercase fs-7">
                                            Menu Utama
                                        </div>
                                    </div>
                                    <div className="menu-item">
                                        <Link
                                            href={route("dashboard")}
                                            className={`menu-link ${
                                                route().current("dashboard*")
                                                    ? "active"
                                                    : ""
                                            }`}
                                        >
                                            <span className="menu-icon">
                                                <i className="ki-duotone ki-home-2 fs-2">
                                                    <span className="path1" />
                                                    <span className="path2" />
                                                </i>
                                            </span>
                                            <span className="menu-title">
                                                Dashboard
                                            </span>
                                        </Link>
                                    </div>
                                    <div className="menu-item">
                                        <Link
                                            href={route(
                                                "pegawai.pegawai.index"
                                            )}
                                            className={`menu-link ${
                                                route().current("pegawai*")
                                                    ? "active"
                                                    : ""
                                            }`}
                                        >
                                            <span className="menu-icon">
                                                <i className="ki-duotone ki-user">
                                                    <i className="path1"></i>
                                                    <i className="path2"></i>
                                                </i>
                                            </span>
                                            <span className="menu-title">
                                                Pegawai
                                            </span>
                                        </Link>
                                    </div>
                                    {auth.role.some((ar) =>
                                        ["admin", "owner"].includes(ar)
                                    ) && (
                                        <div
                                            data-kt-menu-trigger="click"
                                            className={`menu-item menu-accordion ${
                                                route().current("master*")
                                                    ? "hover show"
                                                    : ""
                                            }`}
                                        >
                                            <span className="menu-link">
                                                <span className="menu-icon">
                                                    <span className="svg-icon svg-icon-2">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width={24}
                                                            height={24}
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                        >
                                                            <path
                                                                d="M11.2929 2.70711C11.6834 2.31658 12.3166 2.31658 12.7071 2.70711L15.2929 5.29289C15.6834 5.68342 15.6834 6.31658 15.2929 6.70711L12.7071 9.29289C12.3166 9.68342 11.6834 9.68342 11.2929 9.29289L8.70711 6.70711C8.31658 6.31658 8.31658 5.68342 8.70711 5.29289L11.2929 2.70711Z"
                                                                fill="currentColor"
                                                            />
                                                            <path
                                                                d="M11.2929 14.7071C11.6834 14.3166 12.3166 14.3166 12.7071 14.7071L15.2929 17.2929C15.6834 17.6834 15.6834 18.3166 15.2929 18.7071L12.7071 21.2929C12.3166 21.6834 11.6834 21.6834 11.2929 21.2929L8.70711 18.7071C8.31658 18.3166 8.31658 17.6834 8.70711 17.2929L11.2929 14.7071Z"
                                                                fill="currentColor"
                                                            />
                                                            <path
                                                                opacity="0.3"
                                                                d="M5.29289 8.70711C5.68342 8.31658 6.31658 8.31658 6.70711 8.70711L9.29289 11.2929C9.68342 11.6834 9.68342 12.3166 9.29289 12.7071L6.70711 15.2929C6.31658 15.6834 5.68342 15.6834 5.29289 15.2929L2.70711 12.7071C2.31658 12.3166 2.31658 11.6834 2.70711 11.2929L5.29289 8.70711Z"
                                                                fill="currentColor"
                                                            />
                                                            <path
                                                                opacity="0.3"
                                                                d="M17.2929 8.70711C17.6834 8.31658 18.3166 8.31658 18.7071 8.70711L21.2929 11.2929C21.6834 11.6834 21.6834 12.3166 21.2929 12.7071L18.7071 15.2929C18.3166 15.6834 17.6834 15.6834 17.2929 15.2929L14.7071 12.7071C14.3166 12.3166 14.3166 11.6834 14.7071 11.2929L17.2929 8.70711Z"
                                                                fill="currentColor"
                                                            />
                                                        </svg>
                                                    </span>
                                                </span>
                                                <span className="menu-title">
                                                    Master Data
                                                </span>
                                                <span className="menu-arrow" />
                                            </span>
                                            <div className="menu-sub menu-sub-accordion menu-active-bg">
                                                <div
                                                    data-kt-menu-trigger="click"
                                                    className={`menu-item menu-accordion ${
                                                        route().current(
                                                            "master.skpd*"
                                                        ) ||
                                                        route().current(
                                                            "master.tingkat*"
                                                        ) ||
                                                        route().current(
                                                            "master.status_pegawai*"
                                                        ) ||
                                                        route().current(
                                                            "master.eselon*"
                                                        )
                                                            ? "hover show"
                                                            : ""
                                                    }`}
                                                >
                                                    <span className="menu-link">
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Data Jabatan
                                                        </span>
                                                        <span className="menu-arrow" />
                                                    </span>
                                                    <div
                                                        className={`menu-sub menu-sub-accordion menu-active-bg ${
                                                            route().current(
                                                                "master.skpd*"
                                                            ) ||
                                                            route().current(
                                                                "master.tingkat*"
                                                            ) ||
                                                            route().current(
                                                                "master.status_pegawai*"
                                                            ) ||
                                                            route().current(
                                                                "master.eselon*"
                                                            )
                                                                ? "show"
                                                                : ""
                                                        }`}
                                                    >
                                                        {auth.role.some((ar) =>
                                                            ["owner"].includes(
                                                                ar
                                                            )
                                                        ) && (
                                                            <div
                                                                className={`menu-item ${
                                                                    route().current(
                                                                        "master.status_pegawai*"
                                                                    )
                                                                        ? "show"
                                                                        : ""
                                                                }`}
                                                            >
                                                                <Link
                                                                    className={`menu-link ${
                                                                        route().current(
                                                                            "master.status_pegawai*"
                                                                        )
                                                                            ? "active"
                                                                            : ""
                                                                    }`}
                                                                    href={route(
                                                                        "master.status_pegawai.index"
                                                                    )}
                                                                >
                                                                    <span className="menu-bullet">
                                                                        <span className="bullet bullet-dot" />
                                                                    </span>
                                                                    <span className="menu-title">
                                                                        Status
                                                                        pegawai
                                                                    </span>
                                                                </Link>
                                                            </div>
                                                        )}
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.skpd*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.skpd*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.skpd.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Divisi Kerja
                                                                </span>
                                                            </Link>
                                                        </div>
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.eselon*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.eselon*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.eselon.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Level
                                                                    Jabatan
                                                                </span>
                                                            </Link>
                                                        </div>
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.tingkat*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.tingkat*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.tingkat.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Tingkat
                                                                    Jabatan
                                                                </span>
                                                            </Link>
                                                        </div>
                                                    </div>
                                                </div>
                                                {auth.role.some((ar) =>
                                                    ["owner"].includes(ar)
                                                ) && (
                                                    <div
                                                        data-kt-menu-trigger="click"
                                                        className={`menu-item menu-accordion ${
                                                            route().current(
                                                                "master.pendidikan*"
                                                            ) ||
                                                            route().current(
                                                                "master.jurusan*"
                                                            ) ||
                                                            route().current(
                                                                "master.kursus*"
                                                            )
                                                                ? "hover show"
                                                                : ""
                                                        }`}
                                                    >
                                                        <span className="menu-link">
                                                            <span className="menu-bullet">
                                                                <span className="bullet bullet-dot" />
                                                            </span>
                                                            <span className="menu-title">
                                                                Data Pendidikan
                                                            </span>
                                                            <span className="menu-arrow" />
                                                        </span>
                                                        <div
                                                            className={`menu-sub menu-sub-accordion menu-active-bg ${
                                                                route().current(
                                                                    "master.pendidikan*"
                                                                ) ||
                                                                route().current(
                                                                    "master.jurusan*"
                                                                ) ||
                                                                route().current(
                                                                    "master.kursus*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <div
                                                                className={`menu-item ${
                                                                    route().current(
                                                                        "master.pendidikan*"
                                                                    )
                                                                        ? "show"
                                                                        : ""
                                                                }`}
                                                            >
                                                                <Link
                                                                    className={`menu-link ${
                                                                        route().current(
                                                                            "master.pendidikan*"
                                                                        )
                                                                            ? "active"
                                                                            : ""
                                                                    }`}
                                                                    href={route(
                                                                        "master.pendidikan.index"
                                                                    )}
                                                                >
                                                                    <span className="menu-bullet">
                                                                        <span className="bullet bullet-dot" />
                                                                    </span>
                                                                    <span className="menu-title">
                                                                        Tingkat
                                                                        Pendidikan
                                                                    </span>
                                                                </Link>
                                                            </div>
                                                            <div
                                                                className={`menu-item ${
                                                                    route().current(
                                                                        "master.jurusan*"
                                                                    )
                                                                        ? "show"
                                                                        : ""
                                                                }`}
                                                            >
                                                                <Link
                                                                    className={`menu-link ${
                                                                        route().current(
                                                                            "master.jurusan*"
                                                                        )
                                                                            ? "active"
                                                                            : ""
                                                                    }`}
                                                                    href={route(
                                                                        "master.jurusan.index"
                                                                    )}
                                                                >
                                                                    <span className="menu-bullet">
                                                                        <span className="bullet bullet-dot" />
                                                                    </span>
                                                                    <span className="menu-title">
                                                                        Jurusan
                                                                    </span>
                                                                </Link>
                                                            </div>
                                                            <div
                                                                className={`menu-item ${
                                                                    route().current(
                                                                        "master.kursus*"
                                                                    )
                                                                        ? "show"
                                                                        : ""
                                                                }`}
                                                            >
                                                                <Link
                                                                    className={`menu-link ${
                                                                        route().current(
                                                                            "master.kursus*"
                                                                        )
                                                                            ? "active"
                                                                            : ""
                                                                    }`}
                                                                    href={route(
                                                                        "master.kursus.index"
                                                                    )}
                                                                >
                                                                    <span className="menu-bullet">
                                                                        <span className="bullet bullet-dot" />
                                                                    </span>
                                                                    <span className="menu-title">
                                                                        Kursus &
                                                                        Pelatihan
                                                                    </span>
                                                                </Link>
                                                            </div>
                                                        </div>
                                                    </div>
                                                )}
                                                <div
                                                    data-kt-menu-trigger="click"
                                                    className={`menu-item menu-accordion ${
                                                        route().current(
                                                            "master.lokasi*"
                                                        ) ||
                                                        route().current(
                                                            "master.visit*"
                                                        ) ||
                                                        route().current(
                                                            "master.shift*"
                                                        ) ||
                                                        route().current(
                                                            "master.cuti*"
                                                        ) ||
                                                        route().current(
                                                            "master.izin*"
                                                        ) ||
                                                        route().current(
                                                            "master.ijin*"
                                                        ) ||
                                                        route().current(
                                                            "master.jamKerja*"
                                                        ) ||
                                                        route().current(
                                                            "master.hariLibur*"
                                                        )
                                                            ? "hover show"
                                                            : ""
                                                    }`}
                                                >
                                                    <span className="menu-link">
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Data Presensi
                                                        </span>
                                                        <span className="menu-arrow" />
                                                    </span>
                                                    <div
                                                        className={`menu-sub menu-sub-accordion menu-active-bg ${
                                                            route().current(
                                                                "master.shift*"
                                                            ) ||
                                                            route().current(
                                                                "master.lokasi*"
                                                            ) ||
                                                            route().current(
                                                                "master.visit*"
                                                            ) ||
                                                            route().current(
                                                                "master.hariLibur*"
                                                            )
                                                                ? "show"
                                                                : ""
                                                        }`}
                                                    >
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.hariLibur*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.hariLibur*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.hariLibur.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Hari Libur
                                                                </span>
                                                            </Link>
                                                        </div>
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.cuti*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.cuti*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.cuti.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Cuti
                                                                </span>
                                                            </Link>
                                                        </div>
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.izin*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.izin*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.izin.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Izin
                                                                </span>
                                                            </Link>
                                                        </div>
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.ijin*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.ijin*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.ijin.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Ijin
                                                                </span>
                                                            </Link>
                                                        </div>
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.jamKerjaStatis*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.jamKerjaStatis*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.jamKerjaStatis.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Jam Kerja
                                                                    Statis
                                                                </span>
                                                            </Link>
                                                        </div>
                                                        <div
                                                            data-kt-menu-trigger="click"
                                                            className={`menu-item menu-accordion ${
                                                                route().current(
                                                                    "master.jamKerjaDinamis*"
                                                                )
                                                                    ? "hover show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <span className="menu-link">
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Jam Kerja
                                                                    Dinamis
                                                                </span>
                                                                <span className="menu-arrow" />
                                                            </span>
                                                            <div
                                                                className={`menu-sub menu-sub-accordion menu-active-bg ${
                                                                    route().current(
                                                                        "master.jamKerjaDinamis*"
                                                                    )
                                                                        ? "show"
                                                                        : ""
                                                                }`}
                                                            >
                                                                <div
                                                                    className={`menu-item ${
                                                                        route().current(
                                                                            "master.jamKerjaDinamis.jkdMaster*"
                                                                        )
                                                                            ? "show"
                                                                            : ""
                                                                    }`}
                                                                >
                                                                    <Link
                                                                        className={`menu-link ${
                                                                            route().current(
                                                                                "master.jamKerjaDinamis.jkdMaster*"
                                                                            )
                                                                                ? "active"
                                                                                : ""
                                                                        }`}
                                                                        href={route(
                                                                            "master.jamKerjaDinamis.jkdMaster.index"
                                                                        )}
                                                                    >
                                                                        <span className="menu-bullet">
                                                                            <span className="bullet bullet-dot" />
                                                                        </span>
                                                                        <span className="menu-title">
                                                                            Master
                                                                            Jam
                                                                            Kerja
                                                                        </span>
                                                                    </Link>
                                                                </div>
                                                                <div
                                                                    className={`menu-item ${
                                                                        route().current(
                                                                            "master.jamKerjaDinamis.jkdJadwal*"
                                                                        )
                                                                            ? "show"
                                                                            : ""
                                                                    }`}
                                                                >
                                                                    <Link
                                                                        className={`menu-link ${
                                                                            route().current(
                                                                                "master.jamKerjaDinamis.jkdJadwal*"
                                                                            )
                                                                                ? "active"
                                                                                : ""
                                                                        }`}
                                                                        href={route(
                                                                            "master.jamKerjaDinamis.jkdJadwal.index"
                                                                        )}
                                                                    >
                                                                        <span className="menu-bullet">
                                                                            <span className="bullet bullet-dot" />
                                                                        </span>
                                                                        <span className="menu-title">
                                                                            Jadwal
                                                                            Kerja
                                                                        </span>
                                                                    </Link>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.lokasi*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.lokasi*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.lokasi.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Lokasi Kerja
                                                                </span>
                                                            </Link>
                                                        </div>
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.visit*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.visit*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.visit.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Lokasi
                                                                    Kunjungan
                                                                </span>
                                                            </Link>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    data-kt-menu-trigger="click"
                                                    className={`menu-item menu-accordion ${
                                                        route().current(
                                                            "master.payroll*"
                                                        )
                                                            ? "hover show"
                                                            : ""
                                                    }`}
                                                >
                                                    <span className="menu-link">
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Data Payroll
                                                        </span>
                                                        <span className="menu-arrow" />
                                                    </span>
                                                    <div
                                                        className={`menu-sub menu-sub-accordion menu-active-bg ${
                                                            route().current(
                                                                "master.payroll*"
                                                            )
                                                                ? "show"
                                                                : ""
                                                        }`}
                                                    >
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.payroll.tunjangan*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.payroll.tunjangan*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.payroll.tunjangan.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Master
                                                                    Tunjangan
                                                                </span>
                                                            </Link>
                                                        </div>
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.payroll.lembur*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.payroll.lembur*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.payroll.lembur.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Master
                                                                    Lembur
                                                                </span>
                                                            </Link>
                                                        </div>
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.payroll.absensiPermenit*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.payroll.absensiPermenit*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.payroll.absensiPermenit.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Potongan
                                                                    Telat <br />
                                                                    & Pulang
                                                                    Cepat
                                                                </span>
                                                            </Link>
                                                        </div>
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.payroll.penambahan*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.payroll.penambahan*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.payroll.penambahan.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Komponen
                                                                    Penambahan
                                                                </span>
                                                            </Link>
                                                        </div>
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.payroll.pengurangan*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.payroll.pengurangan*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.payroll.pengurangan.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Komponen
                                                                    Pengurangan
                                                                </span>
                                                            </Link>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div
                                                    data-kt-menu-trigger="click"
                                                    className={`menu-item menu-accordion ${
                                                        route().current(
                                                            "master.suku*"
                                                        ) ||
                                                        route().current(
                                                            "master.penghargaan*"
                                                        ) ||
                                                        route().current(
                                                            "master.lainnya*"
                                                        ) ||
                                                        route().current(
                                                            "master.reimbursement*"
                                                        )
                                                            ? "hover show"
                                                            : ""
                                                    }`}
                                                >
                                                    <span className="menu-link">
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Data Lainnya
                                                        </span>
                                                        <span className="menu-arrow" />
                                                    </span>
                                                    <div
                                                        className={`menu-sub menu-sub-accordion menu-active-bg ${
                                                            route().current(
                                                                "master.suku*"
                                                            ) ||
                                                            route().current(
                                                                "master.penghargaan*"
                                                            ) ||
                                                            route().current(
                                                                "master.lainnya*"
                                                            ) ||
                                                            route().current(
                                                                "master.reimbursement*"
                                                            )
                                                                ? "show"
                                                                : ""
                                                        }`}
                                                    >
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.penghargaan*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.penghargaan*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.penghargaan.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Penghargaan
                                                                </span>
                                                            </Link>
                                                        </div>
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.suku*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.suku*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.suku.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Suku
                                                                </span>
                                                            </Link>
                                                        </div>
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.lainnya*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.lainnya*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.lainnya.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Riwayat
                                                                    Lainnya
                                                                </span>
                                                            </Link>
                                                        </div>
                                                        <div
                                                            className={`menu-item ${
                                                                route().current(
                                                                    "master.reimbursement*"
                                                                )
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <Link
                                                                className={`menu-link ${
                                                                    route().current(
                                                                        "master.reimbursement*"
                                                                    )
                                                                        ? "active"
                                                                        : ""
                                                                }`}
                                                                href={route(
                                                                    "master.reimbursement.index"
                                                                )}
                                                            >
                                                                <span className="menu-bullet">
                                                                    <span className="bullet bullet-dot" />
                                                                </span>
                                                                <span className="menu-title">
                                                                    Reimbursement
                                                                </span>
                                                            </Link>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    )}
                                    {auth.role.some((ar) =>
                                        ["admin", "owner", "opd"].includes(ar)
                                    ) && (
                                        <div
                                            data-kt-menu-trigger="click"
                                            className={`menu-item menu-accordion ${
                                                route().current("pengajuan*") &&
                                                route().current(
                                                    "pengajuan.presensi*"
                                                ) == false &&
                                                route().current(
                                                    "pengajuan.kunjungan*"
                                                ) == false
                                                    ? "hover show"
                                                    : ""
                                            }`}
                                        >
                                            <span className="menu-link">
                                                <span className="menu-icon">
                                                    <span className="svg-icon svg-icon-2">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width={24}
                                                            height={24}
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                        >
                                                            <path
                                                                opacity="0.3"
                                                                d="M21 18.3V4H20H5C4.4 4 4 4.4 4 5V20C10.9 20 16.7 15.6 19 9.5V18.3C18.4 18.6 18 19.3 18 20C18 21.1 18.9 22 20 22C21.1 22 22 21.1 22 20C22 19.3 21.6 18.6 21 18.3Z"
                                                                fill="currentColor"
                                                            />
                                                            <path
                                                                d="M22 4C22 2.9 21.1 2 20 2C18.9 2 18 2.9 18 4C18 4.7 18.4 5.29995 18.9 5.69995C18.1 12.6 12.6 18.2 5.70001 18.9C5.30001 18.4 4.7 18 4 18C2.9 18 2 18.9 2 20C2 21.1 2.9 22 4 22C4.8 22 5.39999 21.6 5.79999 20.9C13.8 20.1 20.1 13.7 20.9 5.80005C21.6 5.40005 22 4.8 22 4Z"
                                                                fill="currentColor"
                                                            />
                                                        </svg>
                                                    </span>
                                                </span>
                                                <span className="menu-title">
                                                    Data Pengajuan
                                                </span>
                                                <span className="menu-arrow" />
                                            </span>
                                            <div
                                                className={`menu-sub menu-sub-accordion menu-active-bg ${route().current(
                                                    "pengajuan*"
                                                )}`}
                                            >
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "pengajuan.cuti*"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "pengajuan.cuti*"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "pengajuan.cuti.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Pengajuan Cuti
                                                        </span>
                                                    </Link>
                                                </div>
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "pengajuan.sakit*"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "pengajuan.sakit*"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "pengajuan.sakit.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Pengajuan Sakit
                                                        </span>
                                                    </Link>
                                                </div>
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "pengajuan.izin*"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "pengajuan.izin*"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "pengajuan.izin.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Pengajuan Izin
                                                        </span>
                                                    </Link>
                                                </div>
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "pengajuan.ijin*"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "pengajuan.ijin*"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "pengajuan.ijin.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Pengajuan Ijin
                                                        </span>
                                                    </Link>
                                                </div>
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "pengajuan.lembur*"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "pengajuan.lembur*"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "pengajuan.lembur.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Pengajuan Lembur
                                                        </span>
                                                    </Link>
                                                </div>
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "pengajuan.reimbursement*"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "pengajuan.reimbursement*"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "pengajuan.reimbursement.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Pengajuan
                                                            Reimbursement
                                                        </span>
                                                    </Link>
                                                </div>
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "pengajuan.tugas*"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "pengajuan.tugas*"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "pengajuan.tugas.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Pengajuan Tugas
                                                        </span>
                                                    </Link>
                                                </div>
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "pengajuan.laporan*"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "pengajuan.laporan*"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "pengajuan.laporan.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Laporan Pengajuan
                                                        </span>
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    )}
                                    {auth.role.some((ar) =>
                                        ["admin", "owner", "opd"].includes(ar)
                                    ) && (
                                        <div
                                            data-kt-menu-trigger="click"
                                            className={`menu-item menu-accordion ${
                                                route().current(
                                                    "pengajuan.presensi*"
                                                )
                                                    ? "hover show"
                                                    : ""
                                            }`}
                                        >
                                            <span className="menu-link">
                                                <span className="menu-icon">
                                                    <span className="svg-icon svg-icon-2">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width={24}
                                                            height={24}
                                                            viewBox="0 0 24 24"
                                                            fill="none"
                                                        >
                                                            <path
                                                                opacity="0.3"
                                                                d="M21 10.7192H3C2.4 10.7192 2 11.1192 2 11.7192C2 12.3192 2.4 12.7192 3 12.7192H6V14.7192C6 18.0192 8.7 20.7192 12 20.7192C15.3 20.7192 18 18.0192 18 14.7192V12.7192H21C21.6 12.7192 22 12.3192 22 11.7192C22 11.1192 21.6 10.7192 21 10.7192Z"
                                                                fill="currentColor"
                                                            />
                                                            <path
                                                                d="M11.6 21.9192C11.4 21.9192 11.2 21.8192 11 21.7192C10.6 21.4192 10.5 20.7191 10.8 20.3191C11.7 19.1191 12.3 17.8191 12.7 16.3191C12.8 15.8191 13.4 15.4192 13.9 15.6192C14.4 15.7192 14.8 16.3191 14.6 16.8191C14.2 18.5191 13.4 20.1192 12.4 21.5192C12.2 21.7192 11.9 21.9192 11.6 21.9192ZM8.7 19.7192C10.2 18.1192 11 15.9192 11 13.7192V8.71917C11 8.11917 11.4 7.71917 12 7.71917C12.6 7.71917 13 8.11917 13 8.71917V13.0192C13 13.6192 13.4 14.0192 14 14.0192C14.6 14.0192 15 13.6192 15 13.0192V8.71917C15 7.01917 13.7 5.71917 12 5.71917C10.3 5.71917 9 7.01917 9 8.71917V13.7192C9 15.4192 8.4 17.1191 7.2 18.3191C6.8 18.7191 6.9 19.3192 7.3 19.7192C7.5 19.9192 7.7 20.0192 8 20.0192C8.3 20.0192 8.5 19.9192 8.7 19.7192ZM6 16.7192C6.5 16.7192 7 16.2192 7 15.7192V8.71917C7 8.11917 7.1 7.51918 7.3 6.91918C7.5 6.41918 7.2 5.8192 6.7 5.6192C6.2 5.4192 5.59999 5.71917 5.39999 6.21917C5.09999 7.01917 5 7.81917 5 8.71917V15.7192V15.8191C5 16.3191 5.5 16.7192 6 16.7192ZM9 4.71917C9.5 4.31917 10.1 4.11918 10.7 3.91918C11.2 3.81918 11.5 3.21917 11.4 2.71917C11.3 2.21917 10.7 1.91916 10.2 2.01916C9.4 2.21916 8.59999 2.6192 7.89999 3.1192C7.49999 3.4192 7.4 4.11916 7.7 4.51916C7.9 4.81916 8.2 4.91918 8.5 4.91918C8.6 4.91918 8.8 4.81917 9 4.71917ZM18.2 18.9192C18.7 17.2192 19 15.5192 19 13.7192V8.71917C19 5.71917 17.1 3.1192 14.3 2.1192C13.8 1.9192 13.2 2.21917 13 2.71917C12.8 3.21917 13.1 3.81916 13.6 4.01916C15.6 4.71916 17 6.61917 17 8.71917V13.7192C17 15.3192 16.8 16.8191 16.3 18.3191C16.1 18.8191 16.4 19.4192 16.9 19.6192C17 19.6192 17.1 19.6192 17.2 19.6192C17.7 19.6192 18 19.3192 18.2 18.9192Z"
                                                                fill="currentColor"
                                                            />
                                                        </svg>
                                                    </span>
                                                </span>
                                                <span className="menu-title">
                                                    Data Presensi
                                                </span>
                                                <span className="menu-arrow" />
                                            </span>
                                            <div className="menu-sub menu-sub-accordion menu-active-bg">
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "pengajuan.presensi.index"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "pengajuan.presensi.index"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "pengajuan.presensi.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Data Harian
                                                        </span>
                                                    </Link>
                                                </div>
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "pengajuan.presensi.laporan_pegawai"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "pengajuan.presensi.laporan_pegawai"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "pengajuan.presensi.laporan_pegawai"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Laporan Pegawai
                                                        </span>
                                                    </Link>
                                                </div>
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "pengajuan.presensi.laporan_divisi"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "pengajuan.presensi.laporan_divisi"
                                                            )
                                                                ? "show"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "pengajuan.presensi.laporan_divisi"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Laporan Divisi
                                                        </span>
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    )}
                                    {auth.role.some((ar) =>
                                        ["admin", "owner", "opd"].includes(ar)
                                    ) && (
                                        <div
                                            data-kt-menu-trigger="click"
                                            className={`menu-item menu-accordion ${
                                                route().current(
                                                    "pengajuan.kunjungan*"
                                                )
                                                    ? "hover show"
                                                    : ""
                                            }`}
                                        >
                                            <span className="menu-link">
                                                <span className="menu-icon">
                                                    <span className="svg-icon svg-icon-2">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width={24}
                                                            height={24}
                                                            fill="currentColor"
                                                            className="bi bi-pin-map-fill"
                                                            viewBox="0 0 16 16"
                                                        >
                                                            <path
                                                                fillRule="evenodd"
                                                                d="M3.1 11.2a.5.5 0 0 1 .4-.2H6a.5.5 0 0 1 0 1H3.75L1.5 15h13l-2.25-3H10a.5.5 0 0 1 0-1h2.5a.5.5 0 0 1 .4.2l3 4a.5.5 0 0 1-.4.8H.5a.5.5 0 0 1-.4-.8l3-4z"
                                                            />
                                                            <path
                                                                fillRule="evenodd"
                                                                d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999z"
                                                            />
                                                        </svg>
                                                    </span>
                                                </span>
                                                <span className="menu-title">
                                                    Data Kunjungan
                                                </span>
                                                <span className="menu-arrow" />
                                            </span>
                                            <div className="menu-sub menu-sub-accordion menu-active-bg">
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "pengajuan.kunjungan.index"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "pengajuan.kunjungan.index"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "pengajuan.kunjungan.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Data Harian
                                                        </span>
                                                    </Link>
                                                </div>
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "pengajuan.kunjungan.laporan"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "pengajuan.kunjungan.laporan"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "pengajuan.kunjungan.laporan"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Laporan Kunjungan
                                                        </span>
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    )}
                                    {auth.role.some((ar) =>
                                        ["admin", "owner"].includes(ar)
                                    ) && (
                                        <div
                                            data-kt-menu-trigger="click"
                                            className={`menu-item menu-accordion ${
                                                route().current("payroll*")
                                                    ? "hover show"
                                                    : ""
                                            }`}
                                        >
                                            <span className="menu-link">
                                                <span className="menu-icon">
                                                    <span className="svg-icon svg-icon-2">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="24"
                                                            height="24"
                                                            fill="currentColor"
                                                            className="bi bi-currency-dollar"
                                                            viewBox="0 0 16 16"
                                                        >
                                                            <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z" />
                                                        </svg>
                                                    </span>
                                                </span>
                                                <span className="menu-title">
                                                    Data Payroll
                                                </span>
                                                <span className="menu-arrow" />
                                            </span>
                                            <div className="menu-sub menu-sub-accordion menu-active-bg">
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "payroll.generate.*"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "payroll.generate.*"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "payroll.generate.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Generate Payroll
                                                        </span>
                                                    </Link>
                                                </div>
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "payroll.tambah.*"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "payroll.tambah.*"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "payroll.tambah.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Daftar Penambahan
                                                        </span>
                                                    </Link>
                                                </div>
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "payroll.kurang.*"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "payroll.kurang.*"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "payroll.kurang.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Daftar Pengurangan
                                                        </span>
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    )}
                                    {auth.role.some((ar) =>
                                        ["admin", "owner"].includes(ar)
                                    ) && (
                                        <Link
                                            href={route("pengumuman.index")}
                                            className={`menu-item menu-accordion ${
                                                route().current("pengumuman*")
                                                    ? "show"
                                                    : ""
                                            }`}
                                        >
                                            <span
                                                className={`menu-link ${
                                                    route().current(
                                                        "pengumuman*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                            >
                                                <span className="menu-icon">
                                                    <span className="svg-icon svg-icon-2">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="16"
                                                            height="16"
                                                            fill="currentColor"
                                                            className="bi bi-rss"
                                                            viewBox="0 0 16 16"
                                                        >
                                                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                                            <path d="M5.5 12a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-3-8.5a1 1 0 0 1 1-1c5.523 0 10 4.477 10 10a1 1 0 1 1-2 0 8 8 0 0 0-8-8 1 1 0 0 1-1-1zm0 4a1 1 0 0 1 1-1 6 6 0 0 1 6 6 1 1 0 1 1-2 0 4 4 0 0 0-4-4 1 1 0 0 1-1-1z" />
                                                        </svg>
                                                    </span>
                                                </span>
                                                <span className="menu-title">
                                                    Pengumuman
                                                </span>
                                            </span>
                                        </Link>
                                    )}
                                    {auth.role.some((ar) =>
                                        ["admin", "owner"].includes(ar)
                                    ) && (
                                        <div
                                            data-kt-menu-trigger="click"
                                            className={`menu-item menu-accordion ${
                                                route().current("users*")
                                                    ? "hover show"
                                                    : ""
                                            }`}
                                        >
                                            <span className="menu-link">
                                                <span className="menu-icon">
                                                    <span className="svg-icon svg-icon-2">
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="24"
                                                            height="24"
                                                            fill="currentColor"
                                                            className="bi bi-people-fill"
                                                            viewBox="0 0 16 16"
                                                        >
                                                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                                            <path
                                                                fillRule="evenodd"
                                                                d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"
                                                            />
                                                            <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                                                        </svg>
                                                    </span>
                                                </span>
                                                <span className="menu-title">
                                                    Manajemen User
                                                </span>
                                                <span className="menu-arrow" />
                                            </span>
                                            <div className="menu-sub menu-sub-accordion menu-active-bg">
                                                {auth.role.some((ar) =>
                                                    ["owner"].includes(ar)
                                                ) && (
                                                    <div
                                                        className={`menu-item ${
                                                            route().current(
                                                                "users.direksi.index"
                                                            )
                                                                ? "show"
                                                                : ""
                                                        }`}
                                                    >
                                                        <Link
                                                            className={`menu-link ${
                                                                route().current(
                                                                    "users.direksi.index"
                                                                )
                                                                    ? "active"
                                                                    : ""
                                                            }`}
                                                            href={route(
                                                                "users.direksi.index"
                                                            )}
                                                        >
                                                            <span className="menu-bullet">
                                                                <span className="bullet bullet-dot" />
                                                            </span>
                                                            <span className="menu-title">
                                                                Direksi
                                                            </span>
                                                        </Link>
                                                    </div>
                                                )}
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "users.hrd.index"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "users.hrd.index"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "users.hrd.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            HRD
                                                        </span>
                                                    </Link>
                                                </div>
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "users.manager.*"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "users.manager.*"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "users.manager.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Kepala Divisi
                                                        </span>
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    )}
                                    <div
                                        data-kt-menu-trigger="click"
                                        className={`menu-item menu-accordion ${
                                            route().current("password*") ||
                                            route().current("perusahaan*")
                                                ? "hover show"
                                                : ""
                                        }`}
                                    >
                                        <span className="menu-link">
                                            <span className="menu-icon">
                                                <span className="svg-icon svg-icon-2">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        width="24"
                                                        height="24"
                                                        fill="currentColor"
                                                        className="bi bi-person-circle"
                                                        viewBox="0 0 16 16"
                                                    >
                                                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                                        <path
                                                            fillRule="evenodd"
                                                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"
                                                        />
                                                    </svg>
                                                </span>
                                            </span>
                                            <span className="menu-title">
                                                Profil
                                            </span>
                                            <span className="menu-arrow" />
                                        </span>
                                        <div className="menu-sub menu-sub-accordion menu-active-bg">
                                            {auth.role.some((ar) =>
                                                ["admin", "owner"].includes(ar)
                                            ) && (
                                                <div
                                                    className={`menu-item ${
                                                        route().current(
                                                            "perusahaan.*"
                                                        )
                                                            ? "show"
                                                            : ""
                                                    }`}
                                                >
                                                    <Link
                                                        className={`menu-link ${
                                                            route().current(
                                                                "perusahaan.*"
                                                            )
                                                                ? "active"
                                                                : ""
                                                        }`}
                                                        href={route(
                                                            "perusahaan.index"
                                                        )}
                                                    >
                                                        <span className="menu-bullet">
                                                            <span className="bullet bullet-dot" />
                                                        </span>
                                                        <span className="menu-title">
                                                            Profile Perusahaan
                                                        </span>
                                                    </Link>
                                                </div>
                                            )}
                                            <div
                                                className={`menu-item ${
                                                    route().current(
                                                        "password.index"
                                                    )
                                                        ? "show"
                                                        : ""
                                                }`}
                                            >
                                                <Link
                                                    className={`menu-link ${
                                                        route().current(
                                                            "password.index"
                                                        )
                                                            ? "active"
                                                            : ""
                                                    }`}
                                                    href={route(
                                                        "password.index"
                                                    )}
                                                >
                                                    <span className="menu-bullet">
                                                        <span className="bullet bullet-dot" />
                                                    </span>
                                                    <span className="menu-title">
                                                        Ubah Password
                                                    </span>
                                                </Link>
                                            </div>
                                            <div className="menu-item">
                                                <Link
                                                    className="menu-link"
                                                    as="button"
                                                    method="POST"
                                                    href={route("logout")}
                                                >
                                                    <span className="menu-bullet">
                                                        <span className="bullet bullet-dot" />
                                                    </span>
                                                    <span className="menu-title">
                                                        Logout
                                                    </span>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        className="app-main flex-column flex-row-fluid"
                        id="kt_app_main"
                    >
                        <div className="d-flex flex-column flex-column-fluid">
                            <div
                                id="kt_app_content_container"
                                className="app-container container-fluid"
                            >
                                {children}
                            </div>
                        </div>
                        <div id="kt_app_footer" className="app-footer">
                            <div className="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                                <div className="text-dark order-2 order-md-1">
                                    <span className="text-muted fw-semibold me-1">
                                        2023©
                                    </span>
                                    <a
                                        href="https://jamkerja.id"
                                        target="_blank"
                                        className="text-gray-800 text-hover-primary"
                                    >
                                        JamKerja.ID
                                    </a>
                                </div>
                                <ul className="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                                    <li className="menu-item">
                                        <a
                                            href="https://jamkerja.id"
                                            className="menu-link px-2"
                                        >
                                            About
                                        </a>
                                    </li>
                                    <li className="menu-item">
                                        <a
                                            href="https://jamkerja.id"
                                            className="menu-link px-2"
                                        >
                                            Support
                                        </a>
                                    </li>
                                    <li className="menu-item">
                                        <a
                                            href="https://jamkerja.id"
                                            className="menu-link px-2"
                                        >
                                            Contact
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

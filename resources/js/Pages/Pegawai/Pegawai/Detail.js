import Authenticated from "@/Layouts/Authenticated";
import { Inertia } from "@inertiajs/inertia";
import { Link } from "@inertiajs/inertia-react";
import React, { useEffect, useState } from "react";
import {
    AvatarGroup,
    Badge,
    Loader,
    Message,
    Uploader,
    useToaster,
} from "rsuite";
import AvatarIcon from "@rsuite/icons/legacy/Avatar";
import ResetPass from "@/Components/Crud/ResetPass";
import ResetImei from "@/Components/Crud/ResetImei";

function previewFile(file, callback) {
    const reader = new FileReader();
    reader.onloadend = () => {
        callback(reader.result);
    };
    reader.readAsDataURL(file);
}

export default function Detail({ pegawai, children }) {
    const [key, setKey] = useState("data-utama");
    const toaster = useToaster();
    const token = document.getElementById("csrf");
    const [uploading, setUploading] = useState(false);
    const [fileInfo, setFileInfo] = useState(null);
    const [values, setValues] = useState({
        nip: pegawai.nip,
        file: pegawai.images ?? "/assets/media/avatars/300-1.jpg",
    });

    useEffect(() => {
        const getActiveTab = JSON.parse(localStorage.getItem("activeTab"));
        if (getActiveTab) {
            setKey(getActiveTab);
        }
    }, []);

    useEffect(() => {
        let size = Object.keys(route().params).length;
        if (size == 1) {
            localStorage.setItem("linkDetail", `"${route().current()}"`);
        }
        localStorage.setItem("activeTab", JSON.stringify(key));
    }, [key]);

    const updateWajah = () => {
        Inertia.post(route('pegawai.wajah.update', pegawai.nip));
    }

    return (
        <div>
            <div className="d-flex flex-column flex-column-fluid">
                <div
                    className="toolbar mb-5 mb-lg-7 d-flex justify-content-between"
                    id="kt_toolbar"
                >
                    <div className="page-title d-flex flex-column me-3">
                        <h1 className="d-flex text-dark fw-bolder my-1 fs-3">
                            Pegawai
                        </h1>
                        <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                            <li className="breadcrumb-item text-gray-600">
                                <Link
                                    preserveScroll
                                    href={route("pegawai.pegawai.index")}
                                    className="text-gray-600 text-hover-primary"
                                >
                                    Pegawai
                                </Link>
                            </li>
                            <li className="breadcrumb-item text-gray-600">
                                Detail
                            </li>
                        </ul>
                    </div>
                    <div className="d-flex align-items-center py-2 py-md-1">
                        <Link
                            preserveScroll
                            href={route("pegawai.pegawai.index")}
                            className="btn btn-dark fw-bolder"
                        >
                            Kembali
                        </Link>
                    </div>
                </div>
                <div className="content">
                    <div className="card mb-6 mb-xl-9">
                        <div className="card-body pt-9 pb-0">
                            <div className="d-flex flex-wrap flex-sm-nowrap mb-6">
                                <div className="d-flex flex-column">
                                    <div className="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                                        <Uploader
                                            fileListVisible={false}
                                            listType="picture"
                                            action={route(
                                                "pegawai.pegawai.upload"
                                            )}
                                            data={{
                                                nip: pegawai.nip,
                                                _token: token.content,
                                            }}
                                            onUpload={(file) => {
                                                setUploading(true);
                                                previewFile(
                                                    file.blobFile,
                                                    (value) => {
                                                        setFileInfo(value);
                                                    }
                                                );
                                            }}
                                            onSuccess={(response, file) => {
                                                console.log(response);
                                                setUploading(false);
                                                toaster.push(
                                                    <Message type="success">
                                                        Uploaded successfully
                                                    </Message>
                                                );
                                            }}
                                            onError={() => {
                                                setFileInfo(null);
                                                setUploading(false);
                                                toaster.push(
                                                    <Message type="error">
                                                        Upload failed
                                                    </Message>
                                                );
                                            }}
                                        >
                                            <button
                                                style={{
                                                    width: 150,
                                                    height: 150,
                                                }}
                                            >
                                                {uploading && (
                                                    <Loader backdrop center />
                                                )}
                                                {fileInfo ? (
                                                    <img
                                                        src={fileInfo}
                                                        width="100%"
                                                        height="100%"
                                                    />
                                                ) : values.file != "" ? (
                                                    <div className="d-flex justify-content-center">
                                                        <img
                                                            src={values.file}
                                                            width="90%"
                                                            height="90%"
                                                        />
                                                    </div>
                                                ) : (
                                                    <AvatarIcon
                                                        style={{ fontSize: 80 }}
                                                    />
                                                )}
                                            </button>
                                        </Uploader>
                                    </div>
                                    {values.file != "http://jamkerja.test/no-image.png" && (
                                        <div className="ml-3">
                                            <button onClick={updateWajah} className="badge badge-primary mt-2">
                                                Jadikan Foto Presensi
                                            </button>
                                        </div>
                                    )}
                                </div>
                                <div className="flex-grow-1">
                                    <div className="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                        <div className="d-flex flex-column">
                                            <div className="d-flex align-items-center mb-1">
                                                <a
                                                    href="#"
                                                    className="text-gray-800 text-hover-primary fs-2 fw-bolder me-3"
                                                >
                                                    {pegawai?.name}
                                                </a>
                                            </div>
                                            <div className="d-flex flex-wrap fw-bold mb-2 fs-5 text-gray-600">
                                                Tempat Lahir :{" "}
                                                {pegawai?.tempat_lahir}
                                            </div>
                                            <div className="d-flex flex-wrap fw-bold mb-2 fs-5 text-gray-600">
                                                Tanggal Lahir :{" "}
                                                {pegawai?.tanggal_lahir}
                                            </div>
                                            <div className="d-flex flex-wrap fw-bold mb-2 fs-5 text-gray-600">
                                                No HP : {pegawai?.no_hp}
                                            </div>
                                            <div className="d-flex flex-wrap fw-bold mb-2 fs-5 text-gray-500">
                                                Alamat : {pegawai?.alamat}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="separator" />
                            <ul className="nav nav-custom nav-line-tabs nav-line-tabs-2x border-transparent fs-6 fw-bolder">
                                <li className="nav-item">
                                    <Link
                                        preserveScroll
                                        className={`nav-link text-active-primary py-5 me-6 ${
                                            key == "data-utama" ? "active" : ""
                                        }`}
                                        onClick={() => setKey("data-utama")}
                                        href="#data-utama"
                                        data-bs-toggle="tab"
                                    >
                                        {" "}
                                        <i class="fa fa-user mr-2"></i> Data
                                        Utama
                                    </Link>
                                </li>
                                <li className="nav-item">
                                    <Link
                                        preserveScroll
                                        className={`nav-link text-active-primary py-5 me-6 ${
                                            key == "data-riwayat"
                                                ? "active"
                                                : ""
                                        }`}
                                        onClick={() => setKey("data-riwayat")}
                                        href="#data-riwayat"
                                        data-bs-toggle="tab"
                                    >
                                        <i class="fa fa-clipboard-list mr-2"></i>{" "}
                                        Data Riwayat
                                    </Link>
                                </li>
                                <li className="nav-item">
                                    <Link
                                        preserveScroll
                                        className={`nav-link text-active-primary py-5 me-6 ${
                                            key == "data-keluarga"
                                                ? "active"
                                                : ""
                                        }`}
                                        onClick={() => setKey("data-keluarga")}
                                        href="#data-keluarga"
                                        data-bs-toggle="tab"
                                    >
                                        <i class="fa fa-users mr-2"></i> Data
                                        Keluarga
                                    </Link>
                                </li>
                                <li className="nav-item">
                                    <Link
                                        preserveScroll
                                        className={`nav-link text-active-primary py-5 me-6 ${
                                            key == "data-lainnya"
                                                ? "active"
                                                : ""
                                        }`}
                                        onClick={() => setKey("data-lainnya")}
                                        href="#data-lainnya"
                                        data-bs-toggle="tab"
                                    >
                                        <i class="fa fa-tasks mr-2"></i> Data
                                        Lainnya
                                    </Link>
                                </li>
                                <li className="nav-item">
                                    <Link
                                        preserveScroll
                                        className={`nav-link text-active-primary py-5 me-6 ${
                                            key == "unduh-berkas"
                                                ? "active"
                                                : ""
                                        }`}
                                        onClick={() => setKey("unduh-berkas")}
                                        href="#unduh-berkas"
                                        data-bs-toggle="tab"
                                    >
                                        <i class="fa fa-file mr-2"></i> Unduh
                                        Berkas
                                    </Link>
                                </li>
                            </ul>
                        </div>

                        <div className="card-body bg-light-primary d-flex flex-wrap p-2 border-danger">
                            <div className="tab-content" id="myTabContent">
                                <div
                                    className={`tab-pane fade ${
                                        key == "data-utama" ? "active show" : ""
                                    }`}
                                    id="data-utama"
                                    role="tabpanel"
                                >
                                    <ul className="nav flex-wrap border-transparent fw-bolder">
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.pegawai.detail*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.pegawai.detail",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fas fa-user-shield mr-1"></i>{" "}
                                                Data Pribadi
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.posisi*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.posisi.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-address-card mr-1"></i>{" "}
                                                Posisi & Jabatan
                                            </Link>
                                        </li>
                                        {/* <li className="nav-item my-1">
                                            <Link preserveScroll className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('pegawai.status*') ? 'active' : ''}`} href={route('pegawai.status.index', pegawai.nip)}><i class="fa fa-address-card mr-1"></i> Data Status</Link>
                                        </li> */}
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.kordinat*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.kordinat.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-map-marker mr-1"></i>{" "}
                                                Data Kordinat
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.wajah*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.wajah.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-smile mr-1"></i>{" "}
                                                Data Wajah
                                            </Link>
                                        </li>
                                    </ul>
                                </div>

                                <div
                                    className={`tab-pane fade ${
                                        key == "data-riwayat"
                                            ? "active show"
                                            : ""
                                    }`}
                                    id="data-riwayat"
                                    role="tabpanel"
                                >
                                    <ul className="nav flex-wrap border-transparent fw-bolder">
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.jabatan*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.jabatan.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-chart-line mr-1"></i>{" "}
                                                Jabatan
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.kgb*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.kgb.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                {" "}
                                                <i class="fa fa-file-invoice-dollar mr-1"></i>{" "}
                                                Gaji Pokok
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.tunjangan*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.tunjangan.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-sort-amount-up mr-1"></i>{" "}
                                                Tunjangan
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.potongan*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.potongan.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-sort-amount-down mr-1"></i>{" "}
                                                Potongan
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.pendidikan*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.pendidikan.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-school mr-1"></i>{" "}
                                                Pendidikan
                                            </Link>
                                        </li>
                                        {/* <li className="nav-item my-1">
                                            <Link preserveScroll className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('pegawai.diklat*') ? 'active' : ''}`} href={route('pegawai.diklat.index', pegawai.nip)}><i class="fa fa-book-reader mr-1"></i> Diklat Struktural</Link>
                                        </li> */}
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.kursus*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.kursus.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-book mr-1"></i>{" "}
                                                Kursus
                                            </Link>
                                        </li>
                                        {/* <li className="nav-item my-1">
                                            <Link preserveScroll className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('pegawai') ? 'active' : ''}`} href="#"><i class="fa fa-check-circle mr-1"></i>  SKP</Link>
                                        </li> */}
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.penghargaan*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.penghargaan.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-award mr-1"></i>{" "}
                                                Penghargaan
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.lembur*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.lembur.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-clock mr-1"></i>{" "}
                                                Lembur
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.reimbursement*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.reimbursement.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-money-check-alt mr-1"></i>{" "}
                                                Reimbursement
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.cuti*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.cuti.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-briefcase mr-1"></i>{" "}
                                                Riwayat Cuti
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.pcuti*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.pcuti.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-chart-pie mr-1"></i>{" "}
                                                Potongan/Penambahan Cuti
                                            </Link>
                                        </li>
                                        {/* <li className="nav-item my-1">
                                            <Link preserveScroll className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('pegawai.shift*') ? 'active' : ''}`} href={route('pegawai.shift.index', pegawai.nip)}><i class="fa fa-chart-pie mr-1"></i> Shift</Link>
                                        </li> */}
                                        {/* <li className="nav-item my-1">
                                            <Link preserveScroll className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('pegawai') ? 'active' : ''}`} href="#"><i class="fa fa-times-circle mr-1"></i> Hukuman Disiplin</Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link preserveScroll className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('pegawai') ? 'active' : ''}`} href="#"><i class="fa fa-sort-numeric-up-alt mr-1"></i> Angka Kredit</Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link preserveScroll className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('pegawai') ? 'active' : ''}`} href="#"><i class="fa fa-stop-circle mr-1"></i> Pemberhentian</Link>
                                        </li> */}
                                    </ul>
                                </div>

                                <div
                                    className={`tab-pane fade ${
                                        key == "data-keluarga"
                                            ? "active show"
                                            : ""
                                    }`}
                                    id="data-keluarga"
                                    role="tabpanel"
                                >
                                    <ul className="nav flex-wrap border-transparent fw-bolder">
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.keluarga.index"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.keluarga.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-users mr-1"></i>{" "}
                                                Semua Keluarga
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.keluarga.orang_tua"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.keluarga.orang_tua",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-user-friends mr-1"></i>{" "}
                                                Orang Tua
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.keluarga.pasangan"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.keluarga.pasangan",
                                                    pegawai.nip
                                                )}
                                            >
                                                {pegawai.jenis_kelamin ==
                                                "laki-laki" ? (
                                                    <span>
                                                        {" "}
                                                        <i class="fa fa-female"></i>{" "}
                                                        Istri{" "}
                                                    </span>
                                                ) : (
                                                    <span>
                                                        {" "}
                                                        <i class="fa fa-male"></i>{" "}
                                                        Suami{" "}
                                                    </span>
                                                )}
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.keluarga.anak"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.keluarga.anak",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-child mr-1"></i>{" "}
                                                Anak
                                            </Link>
                                        </li>
                                    </ul>
                                </div>

                                <div
                                    className={`tab-pane fade ${
                                        key == "data-lainnya"
                                            ? "active show"
                                            : ""
                                    }`}
                                    id="data-lainnya"
                                    role="tabpanel"
                                >
                                    <ul className="nav flex-wrap border-transparent fw-bolder">
                                        {/* <li className="nav-item my-1">
                                            <Link preserveScroll className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('pegawai.lhkpn*') ? 'active' : ''}`} href={route('pegawai.lhkpn.index', pegawai.nip)}><i class="fa fa-list-alt mr-1"></i> LHKPN</Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link preserveScroll className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('pegawai.lhkasn*') ? 'active' : ''}`} href={route('pegawai.lhkasn.index', pegawai.nip)}><i class="fa fa-list-alt mr-1"></i> LHKASN</Link>
                                        </li> */}
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.organisasi*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.organisasi.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-sitemap mr-1"></i>{" "}
                                                Organisasi
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.bahasa*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.bahasa.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-language mr-1"></i>{" "}
                                                Penguasaan Bahasa
                                            </Link>
                                        </li>
                                        {/* <li className="nav-item my-1">
                                            <Link preserveScroll className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${route().current('pegawai') ? 'active' : ''}`} href="#"><i class="fa fa-vote-yea mr-1"></i> Kompetensi</Link>
                                        </li> */}
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.spt*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.spt.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <span class="mr-1">
                                                    <strong>Rp.</strong>
                                                </span>{" "}
                                                SPT TAHUNAN
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.pmk*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.pmk.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-file mr-1"></i>{" "}
                                                Pengalaman Kerja
                                            </Link>
                                        </li>
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.lainnya*"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.lainnya.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-history mr-1"></i>{" "}
                                                Riwayat Lainnya
                                            </Link>
                                        </li>
                                    </ul>
                                </div>

                                <div
                                    className={`tab-pane fade ${
                                        key == "unduh-berkas"
                                            ? "active show"
                                            : ""
                                    }`}
                                    id="unduh-berkas"
                                    role="tabpanel"
                                >
                                    <ul className="nav flex-wrap border-transparent fw-bolder">
                                        <li className="nav-item my-1">
                                            <a
                                                target="_blank"
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase`}
                                                href={route(
                                                    "pegawai.berkas.profile_pdf",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-file mr-1"></i>{" "}
                                                Unduh Profil PDF
                                            </a>
                                        </li>
                                        {/* <li className="nav-item my-1">
                                            <a target='_blank' className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase`} href={route('pegawai.berkas.profile_xls', pegawai.nip)}><i class="fa fa-file mr-1"></i> Unduh Profil XLS</a>
                                        </li> */}
                                        <li className="nav-item my-1">
                                            <Link
                                                preserveScroll
                                                className={`btn btn-success btn-active-dark btn-active-color-secondary fw-boldest fs-8 fs-lg-base nav-link px-3 px-lg-8 mx-1 text-uppercase ${
                                                    route().current(
                                                        "pegawai.berkas.index"
                                                    )
                                                        ? "active"
                                                        : ""
                                                }`}
                                                href={route(
                                                    "pegawai.berkas.index",
                                                    pegawai.nip
                                                )}
                                            >
                                                <i class="fa fa-download mr-1"></i>{" "}
                                                Unduh Berkas
                                            </Link>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    {children ? (
                        children
                    ) : (
                        <div className="card card-flush mt-6 mt-xl-9">
                            <div
                                className="card mb-5 mb-xl-10"
                                id="kt_profile_details_view"
                            >
                                <div className="card-header cursor-pointer">
                                    <div className="card-title m-0">
                                        <h3 className="fw-bolder m-0">
                                            Data Pribadi
                                        </h3>
                                    </div>
                                    <div className="d-flex align-items-center">
                                        <ResetImei
                                            routes={route(
                                                "pegawai.pegawai.reset_imei",
                                                pegawai.nip
                                            )}
                                        />
                                        <ResetPass
                                            routes={route(
                                                "pegawai.pegawai.reset_pass",
                                                pegawai.nip
                                            )}
                                        />
                                        <Link
                                            href={route(
                                                "pegawai.pegawai.edit",
                                                pegawai.nip
                                            )}
                                            className="btn btn-primary align-self-center mr-2"
                                        >
                                            <b>Edit Data</b>
                                        </Link>
                                    </div>
                                </div>
                                <div className="card-body p-9">
                                    <div className="row">
                                        <div class="col-lg-6">
                                            <div className="row mb-7">
                                                <label className="col-lg-4 fw-bold text-muted">
                                                    Nama Lengkap
                                                </label>
                                                <div className="col-lg-8">
                                                    <span className="fw-bolder fs-6 text-gray-800">
                                                        {pegawai.gelar_depan}{" "}
                                                        {pegawai.name}{" "}
                                                        {pegawai.gelar_belakang}
                                                    </span>
                                                </div>
                                            </div>
                                            <div className="row mb-7">
                                                <label className="col-lg-4 fw-bold text-muted">
                                                    Tempat Lahir
                                                </label>
                                                <div className="col-lg-8 fv-row">
                                                    <span className="fw-bold text-gray-800 fs-6">
                                                        {pegawai.tempat_lahir}
                                                    </span>
                                                </div>
                                            </div>
                                            <div className="row mb-7">
                                                <label className="col-lg-4 fw-bold text-muted">
                                                    Tanggal Lahir
                                                </label>
                                                <div className="col-lg-8 d-flex align-items-center">
                                                    <span className="fw-bolder fs-6 text-gray-800 me-2">
                                                        {pegawai.tlahir}
                                                    </span>
                                                </div>
                                            </div>
                                            <div className="row mb-7">
                                                <label className="col-lg-4 fw-bold text-muted">
                                                    Jenis Kelamin
                                                </label>
                                                <div className="col-lg-8">
                                                    <a
                                                        href="#"
                                                        className="fw-bold fs-6 text-gray-800 text-hover-primary text-capitalize"
                                                    >
                                                        {pegawai.jenis_kelamin}
                                                    </a>
                                                </div>
                                            </div>
                                            <div className="row mb-7">
                                                <label className="col-lg-4 fw-bold text-muted">
                                                    Agama
                                                </label>
                                                <div className="col-lg-8">
                                                    <a
                                                        href="#"
                                                        className="fw-bold fs-6 text-gray-800 text-hover-primary text-capitalize"
                                                    >
                                                        {pegawai.kode_agama}
                                                    </a>
                                                </div>
                                            </div>
                                            <div className="row mb-7">
                                                <label className="col-lg-4 fw-bold text-muted">
                                                    Status Perkawinan
                                                </label>
                                                <div className="col-lg-8">
                                                    <a
                                                        href="#"
                                                        className="fw-bold fs-6 text-gray-800 text-hover-primary text-capitalize"
                                                    >
                                                        {pegawai.kode_kawin}
                                                    </a>
                                                </div>
                                            </div>
                                            <div className="row mb-7">
                                                <label className="col-lg-4 fw-bold text-muted">
                                                    Golongan Darah
                                                </label>
                                                <div className="col-lg-8">
                                                    <a
                                                        href="#"
                                                        className="fw-bold fs-6 text-gray-800 text-hover-primary text-capitalize"
                                                    >
                                                        {pegawai.golongan_darah}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div className="row mb-7">
                                                <label className="col-lg-4 fw-bold text-muted">
                                                    Nomor KTP
                                                </label>
                                                <div className="col-lg-8">
                                                    <span className="fw-bolder fs-6 text-gray-800">
                                                        {pegawai.nik}
                                                    </span>
                                                </div>
                                            </div>
                                            <div className="row mb-7">
                                                <label className="col-lg-4 fw-bold text-muted">
                                                    No HP
                                                </label>
                                                <div className="col-lg-8 fv-row">
                                                    <span className="fw-bold text-gray-800 fs-6">
                                                        {pegawai.no_hp}
                                                    </span>
                                                </div>
                                            </div>
                                            <div className="row mb-7">
                                                <label className="col-lg-4 fw-bold text-muted">
                                                    Email
                                                </label>
                                                <div className="col-lg-8 fv-row">
                                                    <span className="fw-bold text-gray-800 fs-6">
                                                        {pegawai.email}
                                                    </span>
                                                </div>
                                            </div>
                                            <div className="row mb-7">
                                                <label className="col-lg-4 fw-bold text-muted">
                                                    Alamat Domisili
                                                </label>
                                                <div className="col-lg-8">
                                                    <a
                                                        href="#"
                                                        className="fw-bold fs-6 text-gray-800 text-hover-primary"
                                                    >
                                                        {pegawai.alamat}
                                                    </a>
                                                </div>
                                            </div>
                                            <div className="row mb-7">
                                                <label className="col-lg-4 fw-bold text-muted">
                                                    Alamat Sesuai KTP
                                                </label>
                                                <div className="col-lg-8">
                                                    <span className="fw-bolder fs-6 text-gray-800">
                                                        {pegawai.alamat_ktp}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}

Detail.layout = (page) => <Authenticated children={page} />;

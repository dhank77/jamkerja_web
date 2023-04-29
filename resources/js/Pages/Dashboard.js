import React from 'react';
import Authenticated from '@/Layouts/Authenticated';
import { Pie } from 'react-chartjs-2';
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js';
import DateNowIndo from '@/Components/Date/DateNowIndo';

ChartJS.register(ArcElement, Tooltip, Legend);


export default function Dashboard(props) {
    const data = {
        labels: ['Perempuan', 'Laki-Laki'],
        datasets: [
            {
                data: props.jenis_kelamin,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                ],
            },
        ],
    };
    const dataAgama = {
        labels: props.label_agama,
        datasets: [
            {
                data: props.agama,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(75, 59, 64, 0.8)',
                ],
            },
        ],
    };
    const dataUmur = {
        labels: props.label_umur,
        datasets: [
            {
                data: props.umur,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(75, 59, 64, 0.8)',
                ],
            },
        ],
    };
    const options = {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            },
        }
    };

    return (
        <div className="content flex-column-fluid mt-10" id="kt_content">
            <div className="row gy-5 g-xl-10">
                <div className="col-sm-3 col-xl-3 mb-xl-10">
                    <div className="card h-lg-100">
                        <div className="card-body d-flex justify-content-between align-items-start flex-column">
                            <div className="m-0">
                                <span className="svg-icon svg-icon-2hx svg-icon-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-people-fill" viewBox="0 0 16 16">
                                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                                        <path fillRule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z" />
                                        <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                                    </svg>
                                </span>
                            </div>
                            <div className="d-flex flex-column my-7">
                                <span className="fw-bold fs-3x text-gray-800 lh-1 ls-n2">{props.pegawai}</span>
                                <div className="m-0">
                                    <span className="fw-bold fs-6 text-gray-800">Jumlah Pegawai</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-sm-3 col-xl-3 mb-xl-10">
                    <div className="card h-lg-100">
                        <div className="card-body d-flex justify-content-between align-items-start flex-column">
                            <div className="m-0">
                                <span className="svg-icon svg-icon-2hx svg-icon-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width={24} height={24} viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M14 3V21H10V3C10 2.4 10.4 2 11 2H13C13.6 2 14 2.4 14 3ZM7 14H5C4.4 14 4 14.4 4 15V21H8V15C8 14.4 7.6 14 7 14Z" fill="currentColor" />
                                        <path d="M21 20H20V8C20 7.4 19.6 7 19 7H17C16.4 7 16 7.4 16 8V20H3C2.4 20 2 20.4 2 21C2 21.6 2.4 22 3 22H21C21.6 22 22 21.6 22 21C22 20.4 21.6 20 21 20Z" fill="currentColor" />
                                    </svg>
                                </span>
                            </div>
                            <div className="d-flex flex-column my-7">
                                <span className="fw-bold fs-3x text-gray-800 lh-1 ls-n2">{props.presensi}</span>
                                <div className="m-0">
                                    <span className="fw-bold fs-6 text-gray-800">Presensi Hari ini</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-sm-3 col-xl-3 mb-xl-10">
                    <div className="card h-lg-100">
                        <div className="card-body d-flex justify-content-between align-items-start flex-column">
                            <div className="m-0">
                                <span className="svg-icon svg-icon-2hx svg-icon-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-calendar-month-fill" viewBox="0 0 16 16">
                                        <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zm.104 7.305L4.9 10.18H3.284l.8-2.375h.02zm9.074 2.297c0-.832-.414-1.36-1.062-1.36-.692 0-1.098.492-1.098 1.36v.253c0 .852.406 1.364 1.098 1.364.671 0 1.062-.516 1.062-1.364v-.253z" />
                                        <path d="M16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zM2.56 12.332h-.71L3.748 7h.696l1.898 5.332h-.719l-.539-1.602H3.1l-.54 1.602zm7.29-4.105v4.105h-.668v-.539h-.027c-.145.324-.532.605-1.188.605-.847 0-1.453-.484-1.453-1.425V8.227h.676v2.554c0 .766.441 1.012.98 1.012.59 0 1.004-.371 1.004-1.023V8.227h.676zm1.273 4.41c.075.332.422.636.985.636.648 0 1.07-.378 1.07-1.023v-.605h-.02c-.163.355-.613.648-1.171.648-.957 0-1.64-.672-1.64-1.902v-.34c0-1.207.675-1.887 1.64-1.887.558 0 1.004.293 1.195.64h.02v-.577h.648v4.03c0 1.052-.816 1.579-1.746 1.579-1.043 0-1.574-.516-1.668-1.2h.687z" />
                                    </svg>
                                </span>
                            </div>
                            <div className="d-flex flex-column my-7">
                                <span className="fw-bold fs-3x text-gray-800 lh-1 ls-n2">{props.bulan}</span>
                                <div className="m-0">
                                    <span className="fw-bold fs-6 text-gray-800">Presensi Bulan ini</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-sm-3 col-xl-3 mb-xl-10">
                    <div className="card h-lg-100">
                        <div className="card-body d-flex justify-content-between align-items-start flex-column">
                            <div className="m-0">
                                <span className="svg-icon svg-icon-2hx svg-icon-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" className="bi bi-clipboard-check-fill" viewBox="0 0 16 16">
                                        <path d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3Zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3Z" />
                                        <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5v-1Zm6.854 7.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708Z" />
                                    </svg>
                                </span>
                            </div>
                            <div className="d-flex flex-column my-7">
                                <span className="fw-bold fs-3x text-gray-800 lh-1 ls-n2">{props.tahun}</span>
                                <div className="m-0">
                                    <span className="fw-bold fs-6 text-gray-800">Presensi Tahun Ini</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div className="row gy-5 g-xl-10">
                <div class="col-12">
                    <div class="float-end">
                        <DateNowIndo />
                        {/* {tampilTanggal} {tampilWaktu} */}
                    </div>
                </div>
                <div className="col-sm-4 col-xl-4 mb-xl-10">
                    <div className="alert alert-primary min-h-500px">
                        <h4><span className="card-label fw-bolder fs-3 mb-1">Daftar Libur Hari ini</span></h4>
                        <br />
                        <table>
                            <tbody>
                                {props.pegawaiLibur && props.pegawaiLibur.map((u, k) => (
                                    <tr key={k}>
                                        <td>
                                            <span className="text-dark fw-bolder fs-6">{k + 1}. {u.name}</span>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div className="col-sm-4 col-xl-4 mb-xl-10">
                    <div className="alert alert-success">
                        <h4><span className="card-label fw-bolder fs-3">Ulang Tahun Hari ini</span></h4>
                        <br />
                        <table>
                            <tbody>
                                {props.pegawaiUltah && props.pegawaiUltah.map((u, k) => (
                                    <tr key={k}>
                                        <td>

                                            <span className='text-dark fw-bolder fs-6'>{k + 1}. {u.tanggal_lahir}</span>&nbsp;&nbsp;-&nbsp;&nbsp;
                                            <span className="text-success fw-bolder fs-6">{u.name}</span>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    <div className="alert alert-secondary">
                        <h4><span className="card-label fw-bolder fs-3">Kunjungan Hari ini</span></h4>
                        <br />
                        <table>
                            <tbody>
                                {props.kunjungan && props.kunjungan.map((u, k) => (
                                    <tr key={k}>
                                        <td>

                                            <span className='text-dark fw-bolder fs-6'>{k + 1}. {u.nama}</span>&nbsp;&nbsp;-&nbsp;&nbsp;
                                            <span className="text-success fw-bolder fs-6">{u.judul}</span>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    <div className="alert alert-danger">
                        <h4><span className="card-label fw-bolder fs-3">Cuti Hari ini</span></h4>
                        <br />
                        <table>
                            <tbody>
                                {props.cutiHariIni && props.cutiHariIni.map((u, k) => (
                                    <tr key={k}>
                                        <td>
                                            <div className="text-danger fw-bolder fs-6">{k + 1}. {u.name}  </div>
                                            <div className="text-dark fw-bolder fs-6"> Cuti :  <b>{u.cuti}</b></div>
                                            <div className="text-dark fw-bolder fs-6 mb-4"> Start-End :  <b>{u.tanggal_mulai} - {u.tanggal_selesai}</b></div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div className="col-sm-4 col-xl-4 mb-xl-10">
                    <div className="alert alert-danger">
                        <h4><span className="card-label fw-bolder fs-3">Sakit Hari ini</span></h4>
                        <br />
                        <table>
                            <tbody>
                                {props.sakitHariIni && props.sakitHariIni.map((u, k) => (
                                    <tr key={k}>
                                        <td>
                                            <span className="text-danger fw-bolder fs-6">{k + 1}.{u.name}  </span>
                                            <span className="text-dark fw-bolder fs-6">  - Hari Ke :  <b>{u.day}</b></span>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    <div className="alert alert-primary">
                        <h4><span className="card-label fw-bolder fs-3">Izin Hari ini</span></h4>
                        <br />
                        <table>
                            <tbody>
                                {props.izinHariIni && props.izinHariIni.map((u, k) => (
                                    <tr key={k}>
                                        <td>
                                            <div className="text-danger fw-bolder fs-6">{k + 1}. {u.name}  </div>
                                            <div className="text-dark fw-bolder fs-6"> Izin :  <b>{u.izin}</b></div>
                                            <div className="text-dark fw-bolder fs-6 mb-4"> Start-End :  <b>{u.tanggal_mulai} - {u.tanggal_selesai}</b></div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                    <div className="alert alert-warning">
                        <h4><span className="card-label fw-bolder fs-3">Ijin Terlambat / Pulang Cepat Hari ini</span></h4>
                        <br />
                        <table>
                            <tbody>
                                {props.ijinTerlambat && props.ijinTerlambat.map((u, k) => (
                                    <tr key={k}>
                                        <td>
                                            <div className="text-danger fw-bolder fs-6">{k + 1}.{u.name}  </div>
                                            <div className="text-dark fw-bolder fs-6 mb-4"> Keterangan :  <b>{u.keterangan}</b></div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div className="row gy-5 g-xl-10">
                <div class="col-12">
                    <div class="float-end">
                        <h4>Summary Kehadiran Bulan Berjalan</h4>
                    </div>
                </div>
                <div className="col-sm-3 col-xl-3 mb-xl-10">
                    <div className="card h-lg-100">
                        <div className="card-body d-flex justify-content-between align-items-start flex-column">
                            <div className="m-0">
                                <span className="svg-icon svg-icon-2hx svg-icon-gray-600 text-success">
                                    <svg xmlns="http://www.w3.org/2000/svg" width={16} height={16} fill="currentColor" className="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z" />
                                    </svg>

                                </span>
                            </div>
                            <div className="d-flex flex-column my-7">
                                <span className="fw-bold fs-3x text-gray-800 lh-1 ls-n2">{props.presensi_summary.tcm}</span>
                                <div className="m-0">
                                    <span className="fw-bold fs-6 text-gray-800">Tidak Ceklok Masuk</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-sm-3 col-xl-3 mb-xl-10">
                    <div className="card h-lg-100">
                        <div className="card-body d-flex justify-content-between align-items-start flex-column">
                            <div className="m-0">
                                <span className="svg-icon svg-icon-2hx svg-icon-gray-600 text-danger">
                                    <svg xmlns="http://www.w3.org/2000/svg" width={16} height={16} fill="currentColor" className="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z" />
                                    </svg>
                                </span>
                            </div>
                            <div className="d-flex flex-column my-7">
                                <span className="fw-bold fs-3x text-gray-800 lh-1 ls-n2">{props.presensi_summary.tcp}</span>
                                <div className="m-0">
                                    <span className="fw-bold fs-6 text-gray-800">Tidak Ceklok Pulang</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-sm-3 col-xl-3 mb-xl-10">
                    <div className="card h-lg-100">
                        <div className="card-body d-flex justify-content-between align-items-start flex-column">
                            <div className="m-0">
                                <span className="svg-icon svg-icon-2hx svg-icon-gray-600 text-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width={16} height={16} fill="currentColor" className="bi bi-backspace-reverse-fill" viewBox="0 0 16 16">
                                        <path d="M0 3a2 2 0 0 1 2-2h7.08a2 2 0 0 1 1.519.698l4.843 5.651a1 1 0 0 1 0 1.302L10.6 14.3a2 2 0 0 1-1.52.7H2a2 2 0 0 1-2-2V3zm9.854 2.854a.5.5 0 0 0-.708-.708L7 7.293 4.854 5.146a.5.5 0 1 0-.708.708L6.293 8l-2.147 2.146a.5.5 0 0 0 .708.708L7 8.707l2.146 2.147a.5.5 0 0 0 .708-.708L7.707 8l2.147-2.146z" />
                                    </svg>
                                </span>
                            </div>
                            <div className="d-flex flex-column my-7">
                                <span className="fw-bold fs-3x text-gray-800 lh-1 ls-n2">{props.presensi_summary.tcb}</span>
                                <div className="m-0">
                                    <span className="fw-bold fs-6 text-gray-800">Tidak Ceklok Break</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-sm-3 col-xl-3 mb-xl-10">
                    <div className="card h-lg-100">
                        <div className="card-body d-flex justify-content-between align-items-start flex-column">
                            <div className="m-0">
                                <span className="svg-icon svg-icon-2hx svg-icon-gray-600 text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width={16} height={16} fill="currentColor" className="bi bi-backspace-fill" viewBox="0 0 16 16">
                                        <path d="M15.683 3a2 2 0 0 0-2-2h-7.08a2 2 0 0 0-1.519.698L.241 7.35a1 1 0 0 0 0 1.302l4.843 5.65A2 2 0 0 0 6.603 15h7.08a2 2 0 0 0 2-2V3zM5.829 5.854a.5.5 0 1 1 .707-.708l2.147 2.147 2.146-2.147a.5.5 0 1 1 .707.708L9.39 8l2.146 2.146a.5.5 0 0 1-.707.708L8.683 8.707l-2.147 2.147a.5.5 0 0 1-.707-.708L7.976 8 5.829 5.854z" />
                                    </svg>
                                </span>
                            </div>
                            <div className="d-flex flex-column my-7">
                                <span className="fw-bold fs-3x text-gray-800 lh-1 ls-n2">{props.presensi_summary.tcab}</span>
                                <div className="m-0">
                                    <span className="fw-bold fs-6 text-gray-800">Tidak Ceklok After Break</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="row gy-5 g-xl-10">
                <div className="col-sm-4 col-xl-4 mb-xl-10">
                    <div className="card">
                        <div className="card-header border-0 pt-5">
                            <h3 className="card-title align-items-start flex-column">
                                <span className="card-label fw-bolder fs-3 mb-1">Grafik Jenis Kelamin</span>
                            </h3>
                        </div>
                        <div className="card-body">
                            <div>
                                <Pie options={options} data={data} />
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-sm-4 col-xl-4 mb-xl-10">
                    <div className="card">
                        <div className="card-header border-0 pt-5">
                            <h3 className="card-title align-items-start flex-column">
                                <span className="card-label fw-bolder fs-3 mb-1">Grafik Berdasarkan Umur</span>
                            </h3>
                        </div>
                        <div className="card-body">
                            <div>
                                <Pie options={options} data={dataUmur} />
                            </div>
                        </div>
                    </div>
                </div>
                <div className="col-sm-4 col-xl-4 mb-xl-10">
                    <div className="card">
                        <div className="card-header border-0 pt-5">
                            <h3 className="card-title align-items-start flex-column">
                                <span className="card-label fw-bolder fs-3 mb-1">Grafik Tingkat Pendidikan</span>
                            </h3>
                        </div>
                        <div className="card-body">
                            <div>
                                <Pie options={options} data={dataAgama} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    );
}

Dashboard.layout = (page) => <Authenticated children={page} />

import React, { useEffect, useState } from 'react'
import Authenticated from '@/Layouts/Authenticated'
import Select from 'react-select'
import Month from '@/Components/Date/Month'
import Year from '@/Components/Date/Year'
import { usePage } from '@inertiajs/inertia-react'
import Skpd from '@/Components/Select/Skpd'

export default function Index() {

    const { auth } = usePage().props;
    const [xlx, setXlx] = useState(0)

    const jenisPengajuan = [
        {
            value: "cuti",
            label: "Cuti",
        },
        {
            value: "sakit",
            label: "Sakit",
        },
        {
            value: "izin",
            label: "Izin",
        },
        {
            value: "ijin",
            label: "Ijin",
        },
        // {
        //     value: "reimbursement",
        //     label: "Reimbursement",
        // },
    ];
    const jenisLaporan = [
        {
            value: "harian",
            label: "Harian",
        },
        {
            value: "bulanan",
            label: "Bulanan",
        },
        {
            value: "tahunan",
            label: "Tahunan",
        },
        {
            value: "periode",
            label: "Periode Cut-off",
        },
        {
            value: "periode_tertentu",
            label: "Periode Tertentu",
        },
       
    ];

    const [data, setData] = useState({
        jenis_laporan: '',
    })

    const pdfDownload = () => {
        setXlx(0);
    }
    const xlsDownload = () => {
        setXlx(1)
    }

    const today = new Date();
    const date = today.setDate(today.getDate());
    const defaultValue = new Date(date).toISOString().split('T')[0]

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7 d-flex justify-content-between">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Pengajuan</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Laporan</li>
                        <li className="breadcrumb-item text-gray-600">Data</li>
                    </ul>
                </div>
            </div>
            <div className="content">
                <div className="card mb-5 mb-xl-8">
                    <div className="card-header border-0 pt-5">
                        <h3 className="card-title align-items-start flex-column">
                            <span className="card-label fw-bolder fs-3 mb-1">Download Laporan Pengajuan</span>
                        </h3>
                    </div>
                    <div className="card-body py-3">
                        <form method='get' action={route("pengajuan.laporan.download")} target="_blank">
                            <div className="px-4 py-5">
                                <div className="mb-4">
                                    <label className='form-label'>Jenis Pengajuan</label>
                                    <Select options={jenisPengajuan} name="jenis_pengajuan" />
                                </div>
                                <div className="mb-4">
                                    <label className='form-label'>Jenis Laporan</label>
                                    <Select onChange={(e) => setData({ ...data, jenis_laporan: e.value })} options={jenisLaporan} name="jenis_laporan" />
                                </div>
                                {
                                    data.jenis_laporan == "harian" &&
                                    <div className="mb-4">
                                        <label className="form-label">Tanggal</label>
                                        <input name='tanggal' type="date" defaultValue={defaultValue} className='form-control' />
                                    </div>
                                }
                                {
                                    data.jenis_laporan == "bulanan" || data.jenis_laporan == 'periode' ?
                                    <div className="mb-4">
                                        <label className="form-label">Bulan</label>
                                        <Month name='bulan' />
                                    </div> : ""
                                }
                                {
                                    data.jenis_laporan == "tahunan" || data.jenis_laporan == "bulanan" || data.jenis_laporan == 'periode' ?
                                        <div className="mb-4">
                                            <label className="form-label">Tahun</label>
                                            <Year name='year' />
                                        </div>
                                        : ""
                                }
                                {
                                    data.jenis_laporan == "periode_tertentu" ?
                                        <>
                                            <div className="mb-4 row">
                                                <div class="col-lg-6">
                                                    <label className="form-label">Tanggal Mulai</label>
                                                    <input type='date' defaultValue={defaultValue} name='tanggal_mulai' className='form-control' />
                                                </div>
                                                <div class="col-lg-6">
                                                    <label className="form-label">Tanggal Selesai</label>
                                                    <input type='date' defaultValue={defaultValue} name='tanggal_selesai' className='form-control' />
                                                </div>
                                            </div>
                                        </>
                                        : ""
                                }
                            </div>
                            <input type="hidden" name="xls" id="xls" value={xlx} />
                            <div className="d-flex justify-content-end">
                                <button onClick={xlsDownload} type="submit" className="btn btn-success mr-2">
                                    Download Excel
                                </button>
                                <button onClick={pdfDownload} type="submit" className="btn btn-danger">
                                    Download PDF
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    )
}

Index.layout = (page) => <Authenticated children={page} />
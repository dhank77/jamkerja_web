import React, { useEffect, useState } from 'react'
import Authenticated from '@/Layouts/Authenticated'
import Select from 'react-select'
import Month from '@/Components/Date/Month'
import Year from '@/Components/Date/Year'
import { usePage } from '@inertiajs/inertia-react'
import Skpd from '@/Components/Select/Skpd'
import { Inertia } from '@inertiajs/inertia'

export default function Add() {

    const { auth } = usePage().props;
    const [data, setData] = useState({
        kode_skpd: auth.user.kode_skpd,
        bulan: '',
        tahun: '',
    })

    const generatePayroll = (e) => {
        e.preventDefault();
        Inertia.post(route('payroll.generate.store'), data);
        
    }
    const changeSelect = (e, name) => setData({ ...data, [name] : e[name] });
    const filterBulan = (e) => setData({ ...data, bulan: e.value });
    const filterTahun = (e) => setData({ ...data, tahun: e.value });


    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7 d-flex justify-content-between">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Payroll</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Generate</li>
                        <li className="breadcrumb-item text-gray-600">Data</li>
                    </ul>
                </div>
            </div>
            <div className="content">
                <div className="card mb-5 mb-xl-8">
                    <div className="card-header border-0 pt-5">
                        <h3 className="card-title align-items-start flex-column">
                            <span className="card-label fw-bolder fs-3 mb-1">Generate Payroll Pegawai</span>
                        </h3>
                    </div>
                    <div className="card-body py-3">
                        <form>
                            <div className="px-4 py-5">
                                {
                                    auth.role.some(ar => ['admin'].includes(ar))  &&
                                        <div className="mb-4">
                                            <label className='form-label'>Pilih Divisi Kerja
                                            <br/> <span className='text-danger'>*Kosongkan Jika ingin Generate Semua Pegawai</span>
                                            </label>
                                            <Skpd valueHandle={data.kode_skpd} onchangeHandle={(e) => changeSelect(e, 'kode_skpd')} />
                                        </div> 
                                }
                                <div className="mb-4">
                                    <label className="form-label">Pilih Bulan</label>
                                    <Month filterBulan={filterBulan} />
                                </div>
                                <div className="mb-4">
                                    <label className="form-label">Pilih Tahun</label>
                                    <Year filterTahun={filterTahun} />
                                </div>


                            </div>
                            <div className="d-flex justify-content-end">
                                <button onClick={generatePayroll} type="button" className="btn btn-danger">
                                    Generate Payroll
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    )
}

Add.layout = (page) => <Authenticated children={page} />
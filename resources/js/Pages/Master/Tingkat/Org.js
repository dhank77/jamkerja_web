import Authenticated from '@/Layouts/Authenticated'
import React, { useEffect, useState } from 'react'
import Skpd from '@/Components/Select/Skpd';
import { Link } from '@inertiajs/inertia-react';
import { usePrevious } from 'react-use';
import { Inertia } from '@inertiajs/inertia';
import HighchartsReact from 'highcharts-react-official';
import * as Highcharts from 'highcharts'
import HighchartsSankey from "highcharts/modules/sankey";
import HighchartsOrganization from "highcharts/modules/organization";
import HighchartsExporting from "highcharts/modules/exporting";
import "./styles.css";

HighchartsSankey(Highcharts);
HighchartsOrganization(Highcharts);
HighchartsExporting(Highcharts);

export default function Org({ parent, kode_skpd, data, send, nama_skpd }) {

    const [values, setValues] = useState({
        'kode_skpd': kode_skpd,
    })

    const prev = usePrevious(values);

    useEffect(() => {
        if (prev) {
            Inertia.get(route(route().current(), { _query: route().params }), values, {
                replace: true,
                preserveState: true,
            })
        }
    }, [values])

    const changeSelect = (e, name) => {
        setValues({ ...values, [name]: e[name] })
    }

    console.log(send);

    const options = {
        chart: {
            height: 600,
            inverted: true
        },
        title: {
            text: 'Struktur Organisasi'
        },
        series: [{
            type: 'organization',
            name: nama_skpd,
            keys: ['from', 'to'],
            data: data,
            nodes: send,
            colorByPoint: false,
            color: '#007ad0',
            dataLabels: {
                color: 'white',
            },
            borderColor: 'white',
            nodeWidth: 65,
            height: 90,
        }],
        tooltip: {
            outside: true
        },
        exporting: {
            allowHTML: true,
            sourceWidth: 800,
            sourceHeight: 600
        },
        accessibility: {
            enabled: false
        }

    }

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7 d-flex justify-content-between">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Jabatan</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Struktur</li>
                        <li className="breadcrumb-item text-gray-500">Index</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1">
                    <Link href={route('master.tingkat.index')} className="btn btn-dark"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="content">
                <div className="card mb-5 mb-xl-8">
                    <div className="card-header border-0 pt-5">
                        <h3 className="card-title align-items-start flex-column">
                            <span className="card-label fw-bolder fs-3 mb-1">Bagan Struktural</span>
                        </h3>
                        <div className="card-toolbar">
                            <div className='w-96'>
                                <Skpd valueHandle={values.kode_skpd} onchangeHandle={(e) => changeSelect(e, 'kode_skpd')} />
                            </div>
                        </div>
                    </div>
                    <div className="card-body py-3">
                        <HighchartsReact
                            highcharts={Highcharts}
                            options={options}

                        />
                    </div>

                </div>
            </div>
        </div>

    )
}

Org.layout = (page) => <Authenticated children={page} />

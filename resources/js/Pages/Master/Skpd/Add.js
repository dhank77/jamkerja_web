import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useMemo, useRef, useState } from 'react'
import { Circle, MapContainer, Marker, Popup, TileLayer } from 'react-leaflet';
import ReactLeafletGoogleLayer from 'react-leaflet-google-layer';
import { InputNumber, Slider } from 'rsuite';
import "leaflet/dist/leaflet.css";

export default function Add({ errors, skpd }) {

    const [values, setValues] = useState({
        kode_skpd: skpd.kode_skpd,
        nama: skpd.nama,
        singkatan: skpd.singkatan,
        istilah: skpd.istilah,
        kordinat: skpd.kordinat,
        latitude: skpd.latitude,
        longitude: skpd.longitude,
        jarak: skpd.jarak ?? 0,
        id: skpd.id,
    })

    const updateData = (e) => {
        if (e.target.name == 'kordinat') {
            let arr = e.target.value.split(",");
            if(arr.length > 1 && arr[0] != "" && arr[1] != "" && arr[0] != " " && arr[1] != " "){
                setValues({ ...values, [e.target.name]: e.target.value, latitude: parseFloat(arr[0].trim()), longitude: parseFloat(arr[1].trim()) })
                setMarkerPosition([parseFloat(arr[0].trim()), parseFloat(arr[1].trim())])
            }
        } else {
            setValues({ ...values, [e.target.name]: e.target.value })
        }
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('master.skpd.store'), values);
    }

    const position = [values.latitude ?? -4.008427, values.longitude ?? 119.622869];
    const [markerPosition, setMarkerPosition] = useState(position)

    const icon = L.icon({
        iconUrl: "/images/vendor/leaflet/dist/marker-icon.png",
        iconSize: [31, 51],
        iconAnchor: [20, 31],
        popupAnchor: [0, -51]
    });

    const markerRef = useRef(null)
    const circleRef = useRef(null)
    const namaRef = useRef(null)
    const singkatanRef = useRef(null)
    const eventHandlers = useMemo(
        () => ({
            dragend() {
                const marker = markerRef.current
                const circle = circleRef.current
                const nama = namaRef.current.value
                const singkatan = singkatanRef.current.value
                if (marker != null) {
                    setMarkerPosition(marker.getLatLng())
                    setValues({
                        ...values,
                        kordinat: marker.getLatLng().lat + ", " + marker.getLatLng().lng,
                        latitude: marker.getLatLng().lat,
                        longitude: marker.getLatLng().lng,
                        jarak: circle.getRadius(),
                        nama: nama,
                        singkatan: singkatan,
                    })

                }
            },
        }),
        [],
    )

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7 d-flex justify-content-between">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Master</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Divisi</li>
                        <li className="breadcrumb-item text-gray-500">Data</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('master.skpd.index')} className="btn btn-primary"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Divisi</span>
                    </h3>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nama Divisi</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="nama" ref={namaRef} type="text" onChange={updateData} value={values.nama} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.nama && <div className="text-danger">{errors.nama}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Singkatan</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="singkatan" ref={singkatanRef} type="text" onChange={updateData} value={values.singkatan} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.singkatan && <div className="text-danger">{errors.singkatan}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="form-label">Lokasi Divisi</label>
                            <div>
                                <MapContainer center={position} zoom={5} scrollWheelZoom={false} style={{ height: "600px", width: "100%" }}>
                                    <ReactLeafletGoogleLayer apiKey='AIzaSyA1MgLuZuyqR_OGY3ob3M52N46TDBRI_9k' type={'roadmap'} />
                                    <Marker
                                        position={markerPosition}
                                        icon={icon}
                                        draggable={true}
                                        eventHandlers={eventHandlers}
                                        ref={markerRef}
                                    >
                                        <Popup>
                                            Sesuaikan Titik Yang diinginkan.
                                        </Popup>
                                    </Marker>
                                    <Circle
                                        ref={circleRef}
                                        center={markerPosition}
                                        pathOptions={{ color: 'red', fillColor: 'red' }}
                                        radius={values.jarak}
                                    />
                                </MapContainer>
                            </div>
                        </div>
                        <div className="row mb-6">
                            <div className="col-sm-12 col-lg-6 mb-4">
                                <label htmlFor="kordinat" className="form-label">Kordinat</label>
                                <input type="text" name="kordinat" id="kordinat" className="mt-1 form-control form-control-lg form-control-solid" onChange={updateData} value={values.kordinat} />
                            </div>
                            <div className="col-sm-12 col-lg-6 mb-4">
                                <label className="form-label">Jarak Wilayah (m)</label>
                                <div class="row">
                                    <div class="col-9">
                                        <Slider
                                            min={100}
                                            max={10000}
                                            progress
                                            style={{ marginTop: 16 }}
                                            value={values.jarak}
                                            onChange={value => {
                                                setValues({ ...values, jarak: value });
                                            }}
                                        />
                                    </div>
                                    <div class="col-3">
                                        <InputNumber
                                            min={100}
                                            max={10000}
                                            value={values.jarak}
                                            onChange={value => {
                                                setValues({ ...values, jarak: value });
                                            }}
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="float-right">
                            <button type="submit" className="btn btn-primary">Simpan</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    )
}

Add.layout = (page) => <Authenticated children={page} />
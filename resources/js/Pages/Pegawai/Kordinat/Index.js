import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import React, { useMemo, useRef, useState } from 'react'
import { Circle, MapContainer, Marker, Popup, TileLayer } from 'react-leaflet';
import { InputNumber, Slider } from 'rsuite';
import "leaflet/dist/leaflet.css";
import Detail from '../Pegawai/Detail';
import { Link } from '@inertiajs/inertia-react';

export default function Index({ pegawai }) {

    const [values, setValues] = useState({
        kordinat: pegawai.kordinat,
        latitude: pegawai.latitude,
        longitude: pegawai.longitude,
        jarak: pegawai.jarak,
    })

    const updateData = (e) => {
        if (e.target.name == 'kordinat') {
            let arr = e.target.value.split(",");
            setValues({ ...values, [e.target.name]: e.target.value, latitude: parseFloat(arr[0].trim()), longitude: parseFloat(arr[1].trim()) })
            setMarkerPosition([parseFloat(arr[0].trim()), parseFloat(arr[1].trim())])
        } else {
            setValues({ ...values, [e.target.name]: e.target.value })
        }
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.kordinat.store', pegawai.nip), values);
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
    const eventHandlers = useMemo(
        () => ({
            dragend() {
                const marker = markerRef.current
                const circle = circleRef.current
                if (marker != null) {
                    setMarkerPosition(marker.getLatLng())
                    setValues({
                        ...values,
                        kordinat: marker.getLatLng().lat + ", " + marker.getLatLng().lng,
                        latitude: marker.getLatLng().lat,
                        longitude: marker.getLatLng().lng,
                        jarak: circle.getRadius(),
                    })

                }
            },
        }),
        [],
    )

    return (
        <Detail pegawai={pegawai}>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Data Kordinat Pegawai</span>
                    </h3>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.kordinat.reset', pegawai.nip)} class="btn btn-danger fw-bolder me-auto px-4 py-3">Reset Kordinat</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="form-label">Lokasi Pegawai</label>
                            <div>
                                <MapContainer center={position} zoom={13} scrollWheelZoom={false} style={{ height: "600px", width: "100%" }}>
                                    <TileLayer
                                        attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                                    />
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
        </Detail>
    )
}

Index.layout = (page) => <Authenticated children={page} />
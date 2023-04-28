import { Inertia } from '@inertiajs/inertia'
import axios from 'axios'
import React, { useEffect, useState } from 'react'
import { Button, CheckPicker, Modal } from 'rsuite'

export default function JksModal({ kode_jam_kerja }) {

    const [data, setData] = useState({})
    const [checked, setChecked] = useState({})
    const [pegawai, setPegawai] = useState([])
    const [open, setOpen] = useState(false);
    const handleOpen = () => {
        setOpen(true);
    };
    const handleClose = () => {
        setOpen(false);
    };
    const updateChecked = (e) => {
        setChecked(e);
    };

    const getData = async () => {
        let res = await axios.get(route("master.jksPegawai.index", kode_jam_kerja))
        setData(res.data)
    };

    const getPegawai = async () => {
        let res = await axios.get(route("master.jksPegawai.all_free"))
        setPegawai(res.data);
    };

    const addJks = async () => {
        Inertia.post(route('master.jksPegawai.store'), { checked, kode_jam_kerja }, {
            onSuccess: () => {
                setChecked([])
                getData();
                getPegawai();
            }
        });
    };

    const deleteJks = async (nip) => {
        Swal.fire({
            title: 'Apakah anda yakin menghapus data?',
            text: "Mohon diperhatikan kembali!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya!'
        }).then((result) => {
            if (result.isConfirmed) {
                Inertia.delete(route('master.jksPegawai.delete', nip), {
                    onSuccess: () => {
                        getData();
                        getPegawai();
                        setChecked([])
                    }
                });
            }
        })
    };

    useEffect(() => {
        getData();
        getPegawai();
    }, [kode_jam_kerja])

    return (
        <>
            <Modal open={open} onClose={handleClose}>
                <Modal.Header>
                    <Modal.Title><span className="text-lg font-semibold">Pilih Pegawai </span></Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <div className='row' style={{ width: '100%', height: '200px' }}>
                        <div class="col-lg-12">
                            <CheckPicker onChange={updateChecked} data={pegawai} block />
                            <div className='float-end mt-2'>
                                <button onClick={() => addJks()} className='btn btn-success'>Tambah</button>
                            </div>
                            <br />
                            <h6>Pegawai Terpilih</h6>
                            {
                                data.length > 0 && data.map((e, k) => (
                                    <div key={k} className="d-flex mt-2">
                                        <div className='d-flex'>
                                            <img src={e.image} className='h-25px mr-2' />
                                            <span className='text-dark fs-4'>{e.nama}</span>
                                        </div>
                                        <button onClick={() => deleteJks(e.nip)} className='ml-4 badge badge-danger'>X</button>
                                    </div>
                                ))
                            }
                        </div>
                    </div>
                </Modal.Body>
                <Modal.Footer>
                    <Button onClick={handleClose} appearance="primary">
                        Cancel
                    </Button>
                </Modal.Footer>
            </Modal>
            <div className="dropdown-item  menu-item px-3">
                <a href='#' onClick={handleOpen} className="menu-link px-3">
                    <i className='fa fa-users mr-2 text-success'></i> Pilih Pegawai </a>
            </div>
        </>
    )
}

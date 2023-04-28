import { Inertia } from '@inertiajs/inertia'
import axios from 'axios'
import React, { useEffect, useState } from 'react'
import { Button, CheckPicker, Modal } from 'rsuite'
import Input from '../Crud/Input'

export default function CutiModal({ nip }) {

    const [data, setData] = useState([])
    const [cutiTahunan, setCutiTahunan] = useState()
    const [open, setOpen] = useState(false);
    const handleOpen = () => {
        setOpen(true);
    };
    const handleClose = () => {
        setOpen(false);
    };
    const handleCHange = (e) => {
        setCutiTahunan(e.target.value)
    };

    const getData = async () => {
        let res = await axios.get(route("pegawai.pegawai.json_cuti", nip))
        setData(res.data)
        setCutiTahunan(res.data.cuti_tahunan)
    };

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('pegawai.pegawai.cuti_update', nip), { cuti_tahunan : cutiTahunan },{
            onSuccess: () => {
                getData();
            }
        });
    }
    
    useEffect(() => {
        getData();
    }, [nip])

    return (
        <>
            <Modal open={open} onClose={handleClose}>
                <Modal.Header>
                    <Modal.Title><span className="text-lg font-semibold">Rekapitulasi Cuti </span></Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <div className='row' style={{ width: '100%', height: '200px' }}>
                        <div class="col-lg-12">
                            <form onSubmit={submit}>
                                <Input type='number' name="cuti_tahunan" onChangeHandle={handleCHange} values={cutiTahunan} required={true}  />
                                <div className='mt-4 float-end'>
                                    <button type='submit' className='btn btn-success'><b>Ubah</b></button>
                                </div>
                            </form>
                            <br />
                            <br />
                            <br />
                            <br />

                            {
                                data.length != 0 && data.potongan.length > 0 && data.potongan.map((d, k) => (
                                    <div key={k}>
                                        {
                                            k == 0 &&
                                            <h6>Rekap Potongan / Penambahan Cuti Tahun Ini</h6>
                                        }
                                        <b> =&gt; {d.keterangan.toUpperCase()} - {d.hari} Hari</b>
                                    </div>
                                ))
                            }
                            <br/>
                            <h6 className='text-primary'>Total Jatah Cuti Tahun Ini {data.total}</h6>

                        </div>
                    </div>
                </Modal.Body>
                <Modal.Footer>
                    <Button onClick={handleClose} appearance="primary">
                        Cancel
                    </Button>
                </Modal.Footer>
            </Modal>
            <a href='#' onClick={handleOpen} className="btn btn-warning mr-2"><b>Jatah Cuti</b> </a>
        </>
    )
}

import axios from 'axios'
import React, { useState } from 'react'
import { Button, Loader, Modal } from 'rsuite'
import Iframe from 'react-iframe'

export default function Slipgaji({ nip, kode_payroll }) {

    const [data, setData] = useState("")
    const [open, setOpen] = useState(false);
    const handleOpen = () => {
        setOpen(true);
        setTimeout(() => {
            setData("ok")
        }, 200)
    };
    const handleClose = () => {
        setOpen(false);
        setData("")
    };

    return (
        <>
            <Modal size="lg" open={open} onClose={handleClose}>
                <Modal.Header>
                    <Modal.Title><span className="text-lg font-semibold">Slip Gaji </span></Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    {
                        data == "" ?
                            <div style={{ height: 450 }}>
                                <Loader center className='text-danger text-center' size="lg" />
                            </div>
                            :
                            <Iframe width='100%' height='500px' url={route('payroll.generate.slip', { nip: nip, kode_payroll: kode_payroll }) + "#zoom=80"} />
                    }
                    <br/><br/>
                </Modal.Body>
                <Modal.Footer>
                    <Button onClick={handleClose} appearance="primary">
                        Cancel
                    </Button>
                </Modal.Footer>
            </Modal>
            <div className="dropdown-item  menu-item px-3">
                <a href='#' onClick={handleOpen} className="menu-link px-3">
                    <i className='fa fa-book mr-2 text-warning'></i> Slip Gaji </a>
            </div>
        </>
    )
}

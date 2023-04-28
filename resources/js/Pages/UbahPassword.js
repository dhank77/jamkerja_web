import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import React, { useState } from 'react'
import Swal from 'sweetalert2';

export default function UbahPassword() {

    const [values, setValues] = useState({
        password: '',
        password_baru: '',
        password_baru2: '',
    })

    const changeValue = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value });
    }

    const saveData = async (e) => {
        e.preventDefault();
        if ((values.password_baru != values.password_baru2) || values.password == '') {
            Swal.fire('Gagal!', 'Password tidak sesuai!', 'error');
        } else {
            Inertia.post(route('ubah.password.update'), values);
        }
    }

    return (
        <div className="card mb-5 mb-xl-8">
            <div className="card-header border-0 pt-5">
                <h3 className="card-title align-items-start flex-column">
                    <span className="card-label fw-bolder fs-3 mb-1">Ubah Password</span>
                </h3>
            </div>
            <div className="card-body">
                <form onSubmit={saveData}>
                    <div className="row">
                        <div className="col-lg-12 mb-4">
                            <label htmlFor="password" className="form-label">Password Lama</label>
                            <input type="password" name="password" id="password" className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.password} />
                        </div>
                        <div className="col-lg-12 mb-4">
                            <label htmlFor="password_baru" className="form-label">Password Baru</label>
                            <input type="password" name="password_baru" id="password_baru" className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.password_baru} />
                        </div>
                        <div className="col-lg-12 mb-4">
                            <label htmlFor="password_baru2" className="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_baru2" id="password_baru2" className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.password_baru2} />
                        </div>
                    </div>
                    <div className="float-end">
                        <button type="submit" className="btn btn-primary">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    )
}

UbahPassword.layout = (page) => <Authenticated children={page} />
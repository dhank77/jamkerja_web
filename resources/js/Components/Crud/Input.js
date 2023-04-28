import { usePage } from '@inertiajs/inertia-react';
import React from 'react'

export default function Input({
    type = 'text',
    labels = '',
    name,
    onChangeHandle,
    values,
    required,
    disabled = false,
}) {
    const {errors} = usePage().props;
    let label = name.replace("_", " ").replace("_", " ").replace("_", " ").replace('kode_', "");

    return (
        <div className="row mb-6">
            <label className={`col-lg-3 col-form-label fw-bold fs-6 text-capitalize ${required == true ? 'required' : ''}`}>{labels != '' ? labels : label}</label>
            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                <input name={name} disabled={disabled} type={type} required={required}
                    onChange={onChangeHandle} value={values} className="form-control form-control-lg form-control-solid" placeholder={label} />
            </div>
            {errors[name] && <div className="text-danger">{errors[name]}</div>}
        </div>
    )
}

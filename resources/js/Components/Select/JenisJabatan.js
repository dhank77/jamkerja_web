import React from 'react'
import Select from 'react-select'

export default function JenisJabatan({ onchangeHandle, valueHandle, className = '' }) {

    const options = [
        { value : '1', jenis_jabatan: '1', label: 'Struktural' },
        { value : '2', jenis_jabatan: '2', label: 'Fungsional' },
        { value : '4', jenis_jabatan: '4', label: 'Pelaksana' }
    ]

  return (
    <Select options={options} className={className == '' ? 'z-40' : className} onChange={onchangeHandle} value={options.filter(obj => (obj.jenis_jabatan == valueHandle))} />
  )
}

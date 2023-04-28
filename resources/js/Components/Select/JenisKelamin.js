import React from 'react'
import Select from 'react-select'

export default function JenisKelamin({ onchangeHandle, valueHandle }) {

    const options = [
        { value : 'laki-laki', jenis_kelamin: 'laki-laki', label: 'Laki-laki' },
        { value : 'perempuan', jenis_kelamin: 'perempuan', label: 'Perempuan' },
    ]

  return (
    <Select options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.jenis_kelamin == valueHandle))} />
  )
}

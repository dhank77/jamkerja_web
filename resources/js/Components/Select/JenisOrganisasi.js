import React from 'react'
import Select from 'react-select'

export default function JenisOrganisasi({ onchangeHandle, valueHandle }) {

    const options = [
        { value : 'sosial', jenis_organisasi: 'sosial', label: 'Sosial' },
        { value : 'profesi', jenis_organisasi: 'profesi', label: 'Profesi' },
    ]

  return (
    <Select options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.jenis_organisasi == valueHandle))} />
  )
}

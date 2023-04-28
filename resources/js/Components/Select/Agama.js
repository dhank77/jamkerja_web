import React from 'react'
import Select from 'react-select'

export default function Agama({ onchangeHandle, valueHandle }) {

    const options = [
        { value : 'islam', kode_agama: 'islam', label: 'Islam' },
        { value : 'protestan', kode_agama: 'protestan', label: 'Protestan' },
        { value : 'katholik', kode_agama: 'katholik', label: 'Katholik' },
        { value : 'hindu', kode_agama: 'hindu', label: 'Hindu' },
        { value : 'budha', kode_agama: 'budha', label: 'Budha' },
        { value : 'konghucu', kode_agama: 'konghucu', label: 'Konghucu' },
        { value : 'lainnya', kode_agama: 'lainnya', label: 'Lainnya' },
    ]

  return (
    <Select options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.kode_agama == valueHandle))} />
  )
}

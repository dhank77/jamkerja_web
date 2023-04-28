import React from 'react'
import Select from 'react-select'

export default function PenguasaanBahasa({ onchangeHandle, valueHandle }) {

    const options = [
        { value : 'pasif', penguasaan: 'pasif', label: 'Pasif' },
        { value : 'aktif', penguasaan: 'aktif', label: 'Aktif' },
    ]

  return (
    <Select options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.penguasaan == valueHandle))} />
  )
}

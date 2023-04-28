import React from 'react'
import Select from 'react-select'

export default function JenisLhkpn({ onchangeHandle, valueHandle }) {

    const options = [
        { value : 'A', jenis_form: 'A', label: 'A' },
        { value : 'B', jenis_form: 'B', label: 'B' },
        { value : 'bB', jenis_form: 'B1', label: 'B1' },
    ]

  return (
    <Select options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.jenis_form == valueHandle))} />
  )
}

import React from 'react'
import Select from 'react-select'

export default function JenisSpt({ onchangeHandle, valueHandle }) {

    const options = [
        { value : '1770 S', jenis_spt: '1770 S', label: '1770 S' },
        { value : '1770 SS', jenis_spt: '1770 SS', label: '1770 SS' },
    ]

  return (
    <Select options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.jenis_spt == valueHandle))} />
  )
}

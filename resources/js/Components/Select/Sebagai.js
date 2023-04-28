import React from 'react'
import Select from 'react-select'

export default function Sebagai({ onchangeHandle, valueHandle }) {

    const options = [
        { value : 'defenitif', sebagai: 'defenitif', label: 'Defenitif' },
        { value : 'plt', sebagai: 'plt', label: 'PLT' },
        { value : 'plh', sebagai: 'plh', label: 'PLH' },
        { value : 'pj', sebagai: 'pj', label: 'PJ' },
    ]

  return (
    <Select options={options} onChange={onchangeHandle} value={options.filter(obj => (obj.sebagai == valueHandle))} />
  )
}

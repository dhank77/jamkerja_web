import React, { useEffect, useState } from 'react'
import Select from 'react-select'

export default function Shift({ onchangeHandle, valueHandle }) {

  const [data, setData] = useState([])

   useEffect(() => {
      loadShift();
   }, [])

   const loadShift = async () => {
    try {
      let { data } = await axios.get(route('master.shift.json'));
      setData(data);
    } catch (error) {
      console.log(error);
    }
   }
   

  return (
    <Select className='z-20' options={data} onChange={onchangeHandle} value={data.filter(obj => (obj.kode_shift == valueHandle))} />
  )
}

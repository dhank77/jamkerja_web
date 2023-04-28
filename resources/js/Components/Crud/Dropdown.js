import React from 'react'

export default function Dropdown({ children }) {

    return (
        <>
            <div class="dropdown">
                <button class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <span className="svg-icon svg-icon-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                            <g stroke="none" strokeWidth={1} fill="none" fillRule="evenodd">
                                <rect x={5} y={5} width={5} height={5} rx={1} fill="currentColor" />
                                <rect x={14} y={5} width={5} height={5} rx={1} fill="currentColor" opacity="0.3" />
                                <rect x={5} y={14} width={5} height={5} rx={1} fill="currentColor" opacity="0.3" />
                                <rect x={14} y={14} width={5} height={5} rx={1} fill="currentColor" opacity="0.3" />
                            </g>
                        </svg>
                    </span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    {children}
                </ul>
            </div>
        </>
    )
}

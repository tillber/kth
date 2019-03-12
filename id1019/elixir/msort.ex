b# msort.ex
def msort(l) do
  case l  do
    [] -> []
    [l] -> [l]
    l ->
      {x, y} = msplit(l, [], [])
      merge(msort(x), msort(y))
  end
end

def merge([], s) do s end
def merge(l, []) do l end
def merge([x1 | l1], [x2 | _] = l2) when x1 < x2 do
  [x1 | merge(l1, l2)]
end
def merge(l1,[x2|l2]) do [x2|merge(l1,l2)] end

def msplit([], l1, l2) do {l1, l2} end
def msplit([x | tail], l1, l2) do msplit(tail, [x | l2], l1) end

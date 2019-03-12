# qsort.ex
def qsort([]) do [] end
def qsort([p | l]) do
 {list1, list2} = qsplit(p, l, [], [])
 small = qsort(list1)
 large = qsort(list2)
 append(small, [p | large])
end

def qsplit(_, [], small, large) do {small, large} end
def qsplit(p, [h | t], small, large) do
 if h < p  do
   qsplit(p, t, [h | small], large)
 else
   qsplit(p, t, small, [h | large])
 end
end

def append(list1, list2) do
 case list1 do
   [] -> list2
   [h | t] -> [h | append(t, list2)]
 end
end

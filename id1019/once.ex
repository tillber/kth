# once.ex
def once([]) do {0, 0} end
def once([h|t]) do
  {sum, length} = once(t)
  {sum + h, length + 1}
end

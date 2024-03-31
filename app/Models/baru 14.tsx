<Menu>
            <MenuButton
              py={2}
              transition="all 0.3s"
              _focus={{ boxShadow: "none" }}
            >
              <HStack>
                <Avatar
                  size={"sm"}
                  src={
                    "https://images.unsplash.com/photo-1619946794135-5bc917a27793?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=b616b2c5b373a80ffc9636ba24f7a4a9"
                  }
                />
                <VStack
                  display={{ base: "none", md: "flex" }}
                  alignItems="flex-start"
                  spacing="1px"
                  ml="2"
                >
                  <Text fontSize="sm">Justina Clark</Text>
                  <Text fontSize="xs" color="gray.600">
                    Admin
                  </Text>
                </VStack>

                <Box display={{ base: "none", lg: "flex" }}>
                  <FiChevronDown />
                </Box>
              </HStack>
            </MenuButton>
            <MenuList
              bg={useColorModeValue("white", "gray.900")}
              borderColor={useColorModeValue("gray.200", "gray.700")}
              w="300px"
              borderWidth="1px"
              borderRadius="lg"
              // isOpen={isOpen}
            >
              <MenuDivider />
              <MenuItem
                w="100%"
                _hover={{
                  backgroundColor: "transparent",
                  cursor: "not-allowed",
                }}
              >
                <HStack>
                  {/* <Link href="/myprofile" passHref>
                    <Button
                      colorScheme="teal"
                      key="Profile"
                      size="sm"
                      fontWeight="normal"
                      onClick={handleCloseMenu}
                    >
                      <ImProfile />
                      &nbsp;Profile
                    </Button>
                  </Link>

                  <Button
                    colorScheme="red"
                    key="LogOut"
                    size="sm"
                    fontWeight="normal"
                    // onClick={handleAdd}
                  >
                    <ImProfile />
                    &nbsp;Log Out
                  </Button> */}
                </HStack>
              </MenuItem>
            </MenuList>
            {/* <Box
              maxW="sm"
              borderWidth="1px"
              borderRadius="lg"
              overflow="hidden"
            ></Box> */}
          </Menu>